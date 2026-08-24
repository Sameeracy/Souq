<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\ProductOption;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class ShopController extends Controller
{
    /**
     * Display the marketplace catalog.
     */
    public function index(Request $request)
    {
        $search = $request->query('search');

        $query = Product::with(['seller', 'options'])->latest();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%")
                  ->orWhereHas('seller', function ($sellerQuery) use ($search) {
                      $sellerQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $products = $query->paginate(12)->withQueryString();

        return view('welcome', compact('products', 'search'));
    }

    /**
     * Display a specific product with its variants.
     */
    public function show(Product $product)
    {
        $product->load(['seller', 'options']);
        return view('shop.show', compact('product'));
    }

    /**
     * Add a product to the user's cart.
     */
    public function addToCart(Request $request, Product $product)
    {
        $request->validate([
            'product_option_id' => 'nullable|exists:product_options,id',
            'quantity' => 'required|integer|min:1|max:99'
        ]);

        // If product has options and none was chosen, and options exist, check if option is required
        if ($product->options()->count() > 0 && !$request->filled('product_option_id')) {
            return back()->with('error', 'Please select a variant before adding to cart.');
        }

        $cart = Cart::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'product_option_id' => $request->product_option_id,
        ]);

        $cart->quantity = $cart->exists ? ($cart->quantity + (int)$request->quantity) : (int)$request->quantity;
        $cart->save();

        return redirect()->route('cart.index')->with('success', 'Added "' . $product->title . '" to your cart.');
    }

    /**
     * Remove an item from the cart.
     */
    public function removeFromCart(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $cart->delete();
        return back()->with('success', 'Item removed from cart.');
    }

    /**
     * View the shopping cart.
     */
    public function cart()
    {
        $cartItems = Cart::with(['product.seller', 'option'])
            ->where('user_id', Auth::id())
            ->get();
        
        $total = $cartItems->sum(function ($item) {
            return $item->effective_price * $item->quantity;
        });

        return view('shop.cart', compact('cartItems', 'total'));
    }

    /**
     * Process checkout, create pending order and redirect to Stripe Checkout.
     */
    public function checkout(Request $request)
    {
        $request->validate([
            'delivery_address' => 'required|string|min:5|max:1000',
            'contact_details' => 'required|string|min:3|max:255',
        ]);

        $cartItems = Cart::with(['product.seller', 'option'])
            ->where('user_id', Auth::id())
            ->get();
        
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty. Add products before checking out.');
        }
        try {
            $checkoutSessionUrl = DB::transaction(function () use ($request, $cartItems) {
                $total = $cartItems->sum(function ($item) {
                    return $item->effective_price * $item->quantity;
                });

                // 1. Create the Master Order for the Buyer (Status: pending, awaiting Stripe webhook)
                $orderData = [
                    'user_id' => Auth::id(),
                    'delivery_address' => $request->delivery_address,
                    'contact_details' => $request->contact_details,
                    'total_amount' => $total,
                    'status' => 'pending',
                ];

                if (Schema::hasColumn('orders', 'payment_status')) {
                    $orderData['payment_status'] = 'unpaid';
                }

                $order = Order::create($orderData);

                $lineItems = [];

                // 2. Create Order Items routed to each respective Seller & build Stripe Line Items
                foreach ($cartItems as $item) {
                    $order->items()->create([
                        'seller_id' => $item->product->seller_id,
                        'product_id' => $item->product_id,
                        'product_option_id' => $item->product_option_id,
                        'quantity' => $item->quantity,
                        'price' => $item->effective_price,
                        'status' => 'pending',
                    ]);

                    // Construct product title with variant info
                    $productTitle = $item->product->title;
                    if ($item->option) {
                        $productTitle .= ' (' . $item->option->name . ': ' . $item->option->value . ')';
                    }

                    $lineItems[] = [
                        'price_data' => [
                            'currency' => config('services.stripe.currency', 'pkr'),
                            'product_data' => [
                                'name' => $productTitle,
                                'description' => 'Seller: ' . ($item->product->seller->name ?? 'Verified Seller'),
                            ],
                            'unit_amount' => (int) round($item->effective_price * 100),
                        ],
                        'quantity' => $item->quantity,
                    ];
                }

                // 3. Clear user's cart
                Cart::where('user_id', Auth::id())->delete();

                // 4. Initialize Stripe & Create Hosted Checkout Session
                Stripe::setApiKey(config('services.stripe.secret'));

                $session = StripeSession::create([
                    'payment_method_types' => ['card'],
                    'line_items' => $lineItems,
                    'mode' => 'payment',
                    'customer_email' => Auth::user()->email,
                    'client_reference_id' => (string) $order->id,
                    'metadata' => [
                        'order_id' => (string) $order->id,
                        'user_id' => (string) Auth::id(),
                    ],
                    'success_url' => route('orders.my') . '?payment=success&order_id=' . $order->id,
                    'cancel_url' => route('cart.index') . '?payment=cancelled',
                ]);

                if (Schema::hasColumn('orders', 'stripe_session_id')) {
                    $order->update(['stripe_session_id' => $session->id]);
                }

                return $session->url;
            });

            return redirect()->away($checkoutSessionUrl);

        } catch (\Exception $e) {
            Log::error('Stripe Checkout Exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return redirect()->route('cart.index')->with('error', 'Payment initialization failed: ' . $e->getMessage());
        }
    }

    /**
     * Display buyer's order history.
     */
    public function myOrders()
    {
        $orders = Auth::user()->orders()
            ->with(['items.product', 'items.option', 'items.seller'])
            ->latest()
            ->get();

        return view('shop.orders', compact('orders'));
    }

    /**
     * Mark an entire order as received by the buyer.
     */
    public function markOrderReceived(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $order->update(['status' => 'completed']);
        $order->items()->update(['status' => 'received']);

        return back()->with('success', 'Order #' . $order->id . ' has been marked as received! The delivery notice has been cleared from the seller\'s active message box.');
    }

    /**
     * Mark a specific order item as received by the buyer.
     */
    public function markOrderItemReceived(OrderItem $orderItem)
    {
        if ($orderItem->order->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $orderItem->update(['status' => 'received']);

        // If all items in this order are now received, mark the master order completed as well
        $order = $orderItem->order;
        if ($order->items()->where('status', '!=', 'received')->count() === 0) {
            $order->update(['status' => 'completed']);
        }

        $productName = $orderItem->product->title ?? 'Product';
        return back()->with('success', '"' . $productName . '" has been marked as received! The delivery notice has been cleared from the seller\'s active message box.');
    }
}