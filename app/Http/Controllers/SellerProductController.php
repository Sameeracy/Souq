<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductOption;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SellerProductController extends Controller
{
    /**
     * Display seller dashboard with product catalog, metrics, and side delivery inbox.
     */
    public function index()
    {
        $user = Auth::user();

        // 1. Fetch products belonging to the logged-in seller
        $products = $user->products()->with('options')->latest()->get();

        // 2. Compute performance metrics
        $totalProducts = $products->count();
        $sellerOrderItems = $user->sellerOrderItems()->with(['order.user', 'product', 'option'])->latest()->get();
        $totalSold = $sellerOrderItems->sum('quantity');
        $totalRevenue = $sellerOrderItems->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        // 3. Active incoming dispatch notices for the side delivery message box
        // (Items disappear once marked as received by the buyer)
        $recentOrders = $user->sellerOrderItems()
            ->where(function ($query) {
                $query->whereNull('status')
                      ->orWhere('status', '!=', 'received');
            })
            ->whereHas('order', function ($query) {
                $query->where('status', '!=', 'completed');
            })
            ->with(['order.user', 'product', 'option'])
            ->latest()
            ->get();

        return view('seller.dashboard', compact('products', 'totalProducts', 'totalSold', 'totalRevenue', 'recentOrders', 'sellerOrderItems'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('seller.products.create');
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
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

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $product = Auth::user()->products()->create([
            'title' => $request->title,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
        ]);

        // Save dynamic options/variants if provided
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

        return redirect()->route('seller.dashboard')->with('success', 'Product "' . $product->title . '" created successfully!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        if ($product->seller_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $product->load('options');
        return view('seller.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        if ($product->seller_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

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
            // Remove old image if present
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

        return redirect()->route('seller.dashboard')->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->seller_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()->route('seller.dashboard')->with('success', 'Product deleted successfully.');
    }
}