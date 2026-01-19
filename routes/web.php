<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CollectionController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Admin\SareeController as AdminSareeController;
use App\Http\Controllers\Admin\ReviewController as AdminReviewController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\CollectionController as AdminCollectionController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ContactSettingController as AdminContactSettingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Static Pages
Route::view('/about', 'pages.about')->name('about');

// Blog Routes
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

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
Route::post('/newsletter/subscribe', [App\Http\Controllers\NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');
Route::post('/newsletter/unsubscribe', [App\Http\Controllers\NewsletterController::class, 'unsubscribe'])->name('newsletter.unsubscribe');
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
    // My Account
    Route::get('/my-account', [AccountController::class, 'index'])->name('account');
    Route::put('/my-account/update', [AccountController::class, 'update'])->name('account.update');

    // Address Management
    Route::prefix('addresses')->name('addresses.')->group(function () {
        Route::get('/', [AddressController::class, 'index'])->name('index');
        Route::get('/create', [AddressController::class, 'create'])->name('create');
        Route::post('/', [AddressController::class, 'store'])->name('store');
        Route::get('/{address}/edit', [AddressController::class, 'edit'])->name('edit');
        Route::put('/{address}', [AddressController::class, 'update'])->name('update');
        Route::post('/{address}/set-default', [AddressController::class, 'setDefault'])->name('set-default');
        Route::delete('/{address}', [AddressController::class, 'destroy'])->name('destroy');
    });

    // API route for getting address data
    Route::get('/api/address/{address}', [AddressController::class, 'getAddress'])->name('api.address.get');

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

    // Blog Management
Route::resource('blogs', AdminBlogController::class);
Route::post('/blogs/{blog}/toggle-featured', [AdminBlogController::class, 'toggleFeatured'])->name('blogs.toggle-featured');
Route::post('/blogs/{blog}/toggle-published', [AdminBlogController::class, 'togglePublished'])->name('blogs.toggle-published');
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
        Route::post('/bulk-action', [AdminContactController::class, 'bulk-action'])->name('bulk-action');
    });

    // Order Management
    Route::prefix('orders')->name('orders.')->group(function () {
        Route::get('/', [AdminOrderController::class, 'index'])->name('index');
        Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
        Route::put('/{order}/update-status', [AdminOrderController::class, 'updateStatus'])->name('update-status');
        Route::put('/{order}/update-payment-status', [AdminOrderController::class, 'updatePaymentStatus'])->name('update-payment-status');
        Route::get('/{order}/invoice', [AdminOrderController::class, 'invoice'])->name('invoice');
        Route::delete('/{order}', [AdminOrderController::class, 'destroy'])->name('destroy');
    });

    // User Management
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('/', [AdminUserController::class, 'index'])->name('index');
        Route::post('/', [AdminUserController::class, 'store'])->name('store');
        Route::put('/{id}', [AdminUserController::class, 'update'])->name('update');
        Route::delete('/{id}', [AdminUserController::class, 'destroy'])->name('destroy');
    });

    // Contact Settings
    Route::get('/contact-settings', [AdminContactSettingController::class, 'index'])->name('contact-settings.index');
    Route::put('/contact-settings', [AdminContactSettingController::class, 'update'])->name('contact-settings.update');
});
// Admin Testimonial Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('testimonials', App\Http\Controllers\Admin\TestimonialController::class);
    Route::post('/testimonials/{testimonial}/toggle-featured', [App\Http\Controllers\Admin\TestimonialController::class, 'toggleFeatured'])->name('testimonials.toggle-featured');
    Route::post('/testimonials/{testimonial}/toggle-active', [App\Http\Controllers\Admin\TestimonialController::class, 'toggleActive'])->name('testimonials.toggle-active');
    
    // Newsletter Subscribers
    Route::get('/newsletter-subscribers', [App\Http\Controllers\Admin\NewsletterController::class, 'index'])->name('newsletter.index');
    Route::delete('/newsletter-subscribers/{id}', [App\Http\Controllers\Admin\NewsletterController::class, 'destroy'])->name('newsletter.destroy');
    Route::post('/newsletter-subscribers/export', [App\Http\Controllers\Admin\NewsletterController::class, 'export'])->name('newsletter.export');
});
// Admin Video Management
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::resource('videos', App\Http\Controllers\Admin\VideoController::class);
    Route::post('/videos/{video}/toggle-active', [App\Http\Controllers\Admin\VideoController::class, 'toggleActive'])->name('videos.toggle-active');
});
