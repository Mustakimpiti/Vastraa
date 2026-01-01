<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home Page
Route::get('/', [HomeController::class, 'index'])->name('home');

// For now, we'll use simple view routes for other pages
// You can convert these to controllers later

Route::view('/about', 'pages.about')->name('about');
Route::view('/contact', 'pages.contact')->name('contact');
Route::view('/privacy-policy', 'pages.privacy-policy')->name('privacy');
Route::view('/terms-conditions', 'pages.terms-conditions')->name('terms');
Route::view('/shipping-info', 'pages.shipping-info')->name('shipping');
Route::view('/returns-exchanges', 'pages.returns-exchanges')->name('returns');

// Shop routes (placeholder - we'll implement these later)
Route::view('/shop', 'pages.shop')->name('shop');
Route::view('/shop-collections', 'pages.shop-collections')->name('collections');
Route::view('/shop-single-product', 'pages.shop-single-product')->name('product.show');
Route::view('/shop-cart', 'pages.shop-cart')->name('cart');
Route::view('/shop-checkout', 'pages.shop-checkout')->name('checkout');
Route::view('/shop-wishlist', 'pages.shop-wishlist')->name('wishlist');
Route::view('/login', 'pages.login')->name('login');