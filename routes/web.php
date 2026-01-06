<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\SareeController as AdminSareeController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Static Pages
Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');

// Shop routes - NOW DYNAMIC
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::view('/shop-collections', 'pages.shop-collections')->name('collections');

// Dynamic Product Route
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/{slug}/review', [ProductController::class, 'storeReview'])->name('product.review')->middleware('auth');

// Cart & Checkout
Route::view('/shop-cart', 'pages.shop-cart')->name('cart');
Route::view('/shop-checkout', 'pages.shop-checkout')->name('checkout');

// Wishlist routes (placeholder)
Route::get('/wishlist/add/{id}', function($id) {
    return redirect()->back()->with('success', 'Product added to wishlist!');
})->name('wishlist.add');

// Cart routes (placeholder)
Route::post('/cart/add', function() {
    return redirect()->back()->with('success', 'Product added to cart!');
})->name('cart.add');

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

    // Review Management
    Route::get('/reviews', [AdminReviewController::class, 'index'])->name('reviews.index');
    Route::post('/reviews/{id}/approve', [AdminReviewController::class, 'approve'])->name('reviews.approve');
    Route::post('/reviews/{id}/reject', [AdminReviewController::class, 'reject'])->name('reviews.reject');
    Route::delete('/reviews/{id}', [AdminReviewController::class, 'destroy'])->name('reviews.destroy');
    Route::post('/reviews/quick-approve', [AdminReviewController::class, 'quickApprove'])->name('reviews.quick-approve');
});