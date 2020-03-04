<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'ProductsController@index');

Auth::routes();
Route::get('login/{provider}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\LoginController@handleProviderCallback');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/products/{product}', 'ProductController@show')->name('products.view');

Route::post('/cart/{product}', 'CartController@store')->name('cart.store');
Route::patch('/cart/{product}', 'CartController@update')->name('cart.update');
Route::delete('/cart/{product}', 'CartController@destroy')->name('cart.destroy');
Route::get('/cart', 'CartController@index')->name('cart.index');
Route::post('/cart/switchToSaveForLater/{product}', 'CartController@switchToSaveForLater')->name('cart.switchToSaveForLater');

Route::post('/SaveForLater/{product}', 'saveForLaterController@store')->name('saveForLater.store');
Route::delete('/saveForLater/{product}', 'saveForLaterController@destroy')->name('saveForLater.destroy');
Route::post('/saveForLater/switchToSaveToCart/{product}', 'saveForLaterController@switchToSaveToCart')->name('saveForLater.switchToCart');

Route::group(['middleware' => ['auth']], function () {
    Route::get('/checkout', 'OrderController@store')->name('order.create');
    Route::get('/checkout/{order}', 'OrderController@checkout')->name('order.checkout');
    Route::post('/payment', 'PaymentController@store')->name('payment.verify');
    Route::get('/payment/{payment}', 'PaymentController@show')->name('payment.status');

    Route::get('/orders', 'OrderController@index')->name('orders');
    Route::get('/orders/{order}', 'OrderController@show')->name('orders.view');

    Route::post('/{product}/ratings', 'RatingController@store')->name('rating.store');
});

Route::prefix('admin')->group(function () {
    Route::get('/login', 'Auth\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'Auth\AdminLoginController@login')->name('admin.login.submit');
    Route::get('/register', 'Auth\AdminLoginController@showRegistrationForm')->name('admin.register');
    Route::post('/register', 'Auth\AdminLoginController@register')->name('admin.register.submit');
    Route::post('/logout', 'Auth\AdminLoginController@logout')->name('admin.logout');
    Route::get('/', 'AdminController@index')->name('admin');

    // Password reset routes

    Route::post('/password/email', 'Auth\AdminForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
    Route::post('/password/reset', 'Auth\AdminResetPasswordController@reset')->name('admin.password.update');
    Route::get('/password/reset', 'Auth\AdminForgotPasswordController@showLinkRequestForm')->name('admin.password.request');
    Route::get('/password/reset/{token}', 'Auth\AdminResetPasswordController@showResetForm')->name('admin.password.reset');

    Route::middleware(['auth:admin'])->group(function () {
        Route::resource('/products', 'Admin\ProductController');
        Route::name('admin.')->group(function () {
            Route::resource('/orders', 'Admin\OrderController');
        });
    });
});
