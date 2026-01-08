<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\SareeController as AdminSareeController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\CollectionController as AdminCollectionController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Static Pages
Route::view('/about', 'pages.about')->name('about');

// Contact Page
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact-submit', [ContactController::class, 'submit'])->name('contact.submit');

/*
|--------------------------------------------------------------------------
| Shop & Product Routes
|--------------------------------------------------------------------------
*/

// Shop
Route::get('/shop', [ShopController::class, 'index'])->name('shop');

// Collections
Route::get('/shop-collections', [CollectionController::class, 'index'])->name('collections');
Route::get('/shop-collections/{slug}', [CollectionController::class, 'show'])->name('collections.show');

// Products
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');

/*
|--------------------------------------------------------------------------
| Cart Routes
|--------------------------------------------------------------------------
*/

Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::post('/update', [CartController::class, 'update'])->name('update');
    Route::post('/remove', [CartController::class, 'remove'])->name('remove');
    Route::post('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
    Route::post('/coupon/apply', [CartController::class, 'applyCoupon'])->name('coupon.apply');
    Route::post('/coupon/remove', [CartController::class, 'removeCoupon'])->name('coupon.remove');
});

// Legacy cart route
Route::get('/shop-cart', [CartController::class, 'index'])->name('cart');

/*
|--------------------------------------------------------------------------
| Checkout Routes
|--------------------------------------------------------------------------
*/

Route::get('/shop-checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/process', [CheckoutController::class, 'processCheckout'])->name('checkout.process');
Route::get('/order/success/{orderNumber}', [CheckoutController::class, 'orderSuccess'])->name('order.success');

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| User Account Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // My Orders
    Route::prefix('my-orders')->name('orders.')->group(function () {
        Route::get('/', [OrderController::class, 'index'])->name('index');
        Route::get('/{orderNumber}', [OrderController::class, 'show'])->name('show');
    });

    // Wishlist
    Route::get('/wishlist/add/{id}', function($id) {
        return redirect()->back()->with('success', 'Product added to wishlist!');
    })->name('wishlist.add');

    // Product Reviews
    Route::post('/product/{slug}/review', [ProductController::class, 'storeReview'])->name('product.review');
});

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected)
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Collection Management
    Route::resource('collections', AdminCollectionController::class);

    // Saree Management
    Route::resource('sarees', AdminSareeController::class);
    Route::delete('/sarees/images/{id}', [AdminSareeController::class, 'deleteImage'])->name('sarees.images.delete');

    // Review Management
    Route::prefix('reviews')->name('reviews.')->group(function () {
        Route::get('/', [AdminReviewController::class, 'index'])->name('index');
        Route::post('/{id}/approve', [AdminReviewController::class, 'approve'])->name('approve');
        Route::post('/{id}/reject', [AdminReviewController::class, 'reject'])->name('reject');
        Route::delete('/{id}', [AdminReviewController::class, 'destroy'])->name('destroy');
        Route::post('/quick-approve', [AdminReviewController::class, 'quickApprove'])->name('quick-approve');
    });

    // Contact Management
    Route::prefix('contacts')->name('contacts.')->group(function () {
        Route::get('/', [AdminContactController::class, 'index'])->name('index');
        Route::post('/{id}/mark-read', [AdminContactController::class, 'markAsRead'])->name('mark-read');
        Route::post('/{id}/mark-unread', [AdminContactController::class, 'markAsUnread'])->name('mark-unread');
        Route::post('/{id}/reply', [AdminContactController::class, 'reply'])->name('reply');
        Route::delete('/{id}', [AdminContactController::class, 'destroy'])->name('destroy');
        Route::post('/bulk-action', [AdminContactController::class, 'bulkAction'])->name('bulk-action');
    });
});