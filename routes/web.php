<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AdminForgotPasswordController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\AdminResetPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SaveForLaterController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ProductController::class, 'index']);

Auth::routes();
Route::get('login/{provider}', [LoginController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [LoginController::class, 'handleProviderCallback']);

Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/search', [ShopController::class, 'search'])->name('search');

Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.view');

Route::post('/cart/{product}', [CartController::class, 'store'])->name('cart.store');
Route::patch('/cart/{product}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/{product}', [CartController::class, 'destroy'])->name('cart.destroy');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/switchToSaveForLater/{product}', [CartController::class, 'switchToSaveForLater'])->name('cart.switchToSaveForLater');

Route::post('/saveForLater/{product}', [SaveForLaterController::class, 'store'])->name('saveForLater.store');
Route::delete('/saveForLater/{product}', [SaveForLaterController::class, 'destroy'])->name('saveForLater.destroy');
Route::post('/saveForLater/switchToSaveToCart/{product}', [SaveForLaterController::class, 'switchToSaveToCart'])->name('saveForLater.switchToCart');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/checkout', [OrderController::class, 'store'])->name('order.create');
    Route::get('/checkout/{order}', [OrderController::class, 'checkout'])->name('order.checkout');
    Route::post('/payment', [PaymentController::class, 'store'])->name('payment.verify');
    Route::get('/payment/{payment}', [PaymentController::class, 'show'])->name('payment.status');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.view');

    Route::post('/{product}/ratings', [RatingController::class, 'store'])->name('rating.store');
    Route::patch('/ratings/{rating}', [RatingController::class, 'update'])->name('rating.update');
    Route::delete('/ratings/{rating}', [RatingController::class, 'destroy'])->name('rating.destroy');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminLoginController::class, 'login'])->name('admin.login.submit');
    Route::get('/register', [AdminLoginController::class, 'showRegistrationForm'])->name('admin.register');
    Route::post('/register', [AdminLoginController::class, 'register'])->name('admin.register.submit');
    Route::post('/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    // Password reset routes

    Route::post('/password/email', [AdminForgotPasswordController::class, 'sendResetLinkEmail'])->name('admin.password.email');
    Route::post('/password/reset', [AdminForgotPasswordController::class, 'reset'])->name('admin.password.update');
    Route::get('/password/reset', [AdminForgotPasswordController::class, 'showLinkRequestForm'])->name('admin.password.request');
    Route::get('/password/reset/{token}', [AdminResetPasswordController::class, 'showResetForm'])->name('admin.password.reset');

    Route::middleware(['auth:admin'])->group(function () {
        Route::name('admin.')->group(function () {
            Route::resource('/products', AdminProductController::class);
            Route::resource('/orders', AdminOrderController::class);
            Route::resource('/categories', CategoryController::class)->only(['store']);
        });
    });
});
