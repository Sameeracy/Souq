<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SellerProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SellerOrderController;
use App\Http\Controllers\StripeWebhookController;
use Illuminate\Support\Facades\Auth;

// Public Marketplace Catalog
Route::get('/', [ShopController::class, 'index'])->name('home');
Route::get('/product/{product}', [ShopController::class, 'show'])->name('product.show');

// Stripe Webhook Endpoint (External callback from Stripe)
Route::post('/webhook/stripe', [StripeWebhookController::class, 'handle'])->name('stripe.webhook');

// Intelligent Role-based Dashboard Dispatcher
Route::get('/dashboard', function () {
    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login');
    }

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('seller')) {
        return redirect()->route('seller.dashboard');
    }

    // Default buyer role: show marketplace catalog with success banner
    return redirect()->route('home');
})->middleware(['auth'])->name('dashboard');

// Protected Customer / Buyer Routes (Cart, Checkout & My Orders)
Route::middleware(['auth'])->group(function () {
    Route::get('/cart', [ShopController::class, 'cart'])->name('cart.index');
    Route::post('/cart/{product}', [ShopController::class, 'addToCart'])->name('cart.add');
    Route::post('/cart/remove/{cart}', [ShopController::class, 'removeFromCart'])->name('cart.remove');
    Route::post('/checkout', [ShopController::class, 'checkout'])->name('checkout');
    Route::get('/my-orders', [ShopController::class, 'myOrders'])->name('orders.my');
    Route::post('/orders/{order}/mark-received', [ShopController::class, 'markOrderReceived'])->name('orders.markReceived');
    Route::post('/order-items/{orderItem}/mark-received', [ShopController::class, 'markOrderItemReceived'])->name('orderItems.markReceived');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Seller Protected Routes
Route::middleware(['auth', 'role:seller'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [SellerProductController::class, 'index'])->name('dashboard');
    Route::get('/products/create', [SellerProductController::class, 'create'])->name('products.create');
    Route::post('/products', [SellerProductController::class, 'store'])->name('products.store');
    Route::get('/products/{product}/edit', [SellerProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/{product}', [SellerProductController::class, 'update'])->name('products.update');
    Route::delete('/products/{product}', [SellerProductController::class, 'destroy'])->name('products.destroy');
    Route::get('/orders', [SellerOrderController::class, 'index'])->name('orders.index');
});

// Admin Protected Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::get('/products/{product}/edit', [AdminController::class, 'editProduct'])->name('products.edit');
    Route::put('/products/{product}', [AdminController::class, 'updateProduct'])->name('products.update');
    Route::delete('/products/{product}', [AdminController::class, 'destroyProduct'])->name('products.destroy');
    Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('users.destroy');
});

require __DIR__.'/auth.php';
