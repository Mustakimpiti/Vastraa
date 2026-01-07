<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\SareeController as AdminSareeController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
// REMOVED: use App\Http\Controllers\ContactController; ← This was causing the error

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Static Pages
Route::view('/about', 'pages.about')->name('about');

// Contact Page - Using full namespace to avoid conflicts
Route::middleware('web')->group(function () {
    Route::get('/contact', [\App\Http\Controllers\ContactController::class, 'index'])->name('contact');
    Route::post('/contact-submit', [\App\Http\Controllers\ContactController::class, 'submit'])->name('contact.submit');
});

// Shop routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::view('/shop-collections', 'pages.shop-collections')->name('collections');

// Product routes
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/{slug}/review', [ProductController::class, 'storeReview'])->name('product.review')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
*/
Route::prefix('cart')->name('cart.')->group(function () {
    // View cart
    Route::get('/', [CartController::class, 'index'])->name('index');
    
    // Add to cart
    Route::post('/add', [CartController::class, 'add'])->name('add');
    
    // Update cart item quantity
    Route::post('/update', [CartController::class, 'update'])->name('update');
    
    // Remove item from cart
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    
    // Clear entire cart
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    
    // Get cart count (AJAX)
    Route::get('/count', [CartController::class, 'count'])->name('count');
    
    // Coupon routes
    Route::post('/coupon/apply', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::post('/coupon/remove', [CartController::class, 'removeCoupon'])->name('coupon.remove');
});

// Legacy cart route (for backward compatibility)
Route::get('/shop-cart', [CartController::class, 'index'])->name('cart');

// Checkout
Route::view('/shop-checkout', 'pages.shop-checkout')->name('checkout');

// Wishlist routes (placeholder)
Route::get('/wishlist/add/{id}', function($id) {
    return redirect()->back()->with('success', 'Product added to wishlist!');
})->name('wishlist.add');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

// Guest only routes (redirect if authenticated)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

// Authenticated only routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Saree Management
    Route::resource('sarees', AdminSareeController::class);
    Route::delete('/sarees/images/{id}', [AdminSareeController::class, 'deleteImage'])->name('sarees.images.delete');

    // Review Management
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{id}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{id}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/quick-approve', [AdminReviewController::class, 'quickApprove'])->name('reviews.quick-approve');

    // Contact Management
    Route::get('/contacts', [AdminContactController::class, 'index'])->name('contacts.index');
    Route::post('/contacts/{id}/mark-read', [AdminContactController::class, 'markAsRead'])->name('contacts.mark-read');
    Route::post('/contacts/{id}/mark-unread', [AdminContactController::class, 'markAsUnread'])->name('contacts.mark-unread');
    Route::post('/contacts/{id}/reply', [AdminContactController::class, 'reply'])->name('contacts.reply');
    Route::delete('/contacts/{id}', [AdminContactController::class, 'destroy'])->name('contacts.destroy');
    Route::post('/contacts/bulk-action', [AdminContactController::class, 'bulkAction'])->name('contacts.bulk-action');
});