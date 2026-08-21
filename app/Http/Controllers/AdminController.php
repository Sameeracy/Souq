<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display the admin master dashboard.
     */
    public function index()
    {
        // 1. All registered non-admin users/sellers (and include all users)
        $users = User::with('roles')->latest()->get();
        
        // 2. All products across the platform
        $products = Product::with(['seller', 'options'])->latest()->get();
        
        // 3. Platform Sales Analytics grouped by seller
        $sellerSales = OrderItem::selectRaw('seller_id, sum(price * quantity) as total_sales, sum(quantity) as total_items_sold, count(distinct order_id) as total_orders')
            ->groupBy('seller_id')
            ->with('seller')
            ->get();

        // 4. Overall platform KPI statistics
        $totalPlatformRevenue = OrderItem::sum(\Illuminate\Support\Facades\DB::raw('price * quantity')) ?? 0;
        $totalProductsCount = Product::count();
        $totalOrdersCount = Order::count();
        $totalSellersCount = User::role('seller')->count();
        $totalBuyersCount = User::role('user')->count();

        return view('admin.dashboard', compact(
            'users', 
            'products', 
            'sellerSales', 
            'totalPlatformRevenue', 
            'totalProductsCount', 
            'totalOrdersCount', 
            'totalSellersCount', 
            'totalBuyersCount'
        ));
    }

    /**
     * Show the form for editing any marketplace product.
     */
    public function editProduct(Product $product)
    {
        $product->load(['seller', 'options']);
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update any marketplace product.
     */
    public function updateProduct(Request $request, Product $product)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0.01',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:4096',
            'options' => 'nullable|array',
            'options.*.name' => 'nullable|string|max:100',
            'options.*.value' => 'nullable|string|max:100',
            'options.*.price' => 'nullable|numeric|min:0.01',
        ]);

        $imagePath = $product->image_path;
        if ($request->hasFile('image')) {
            if ($imagePath && Storage::disk('public')->exists($imagePath)) {
                Storage::disk('public')->delete($imagePath);
            }
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product->update([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
        ]);

        // Re-sync options
        $product->options()->delete();
        if ($request->has('options') && is_array($request->options)) {
            foreach ($request->options as $option) {
                if (!empty($option['name']) && !empty($option['value'])) {
                    $product->options()->create([
                        'name' => trim($option['name']),
                        'value' => trim($option['value']),
                        'price' => !empty($option['price']) ? (float)$option['price'] : null,
                    ]);
                }
            }
        }

        return redirect()->route('admin.dashboard')->with('success', 'Product "' . $product->title . '" updated successfully by Admin.');
    }

    /**
     * Delete any product on the marketplace.
     */
    public function destroyProduct(Product $product)
    {
        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $productTitle = $product->title;
        $product->delete();
        
        return redirect()->route('admin.dashboard')->with('success', 'Product "' . $productTitle . '" was deleted.');
    }

    /**
     * Delete a user or seller account.
     */
    public function destroyUser(User $user)
    {
        if ($user->id === Auth::id()) {
            return back()->with('error', 'You cannot delete your own administrative account.');
        }

        $userName = $user->name;
        $user->delete();
        
        return redirect()->route('admin.dashboard')->with('success', 'User account "' . $userName . '" and all associated listings were removed.');
    }
}