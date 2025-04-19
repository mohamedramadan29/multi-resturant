<?php

use Illuminate\Support\Facades\Route;
use App\Http\Middleware\SetRestaurant;
use App\Http\Controllers\front\CartController;
use App\Http\Controllers\front\UserController;
use App\Http\Controllers\front\FrontController;
use App\Http\Controllers\front\OrderController;
use App\Http\Controllers\front\MessageController;
use App\Http\Controllers\front\CheckoutController;
use App\Http\Controllers\front\ResturantFrontController;
//Route::get('/{restaurant:slug}', [ResturantFrontController::class, 'show']);

Route::controller(FrontController::class)->group(function () {
    Route::get('/', 'index')->name('index');
});

Route::prefix('/{restaurant:slug}')->group(function () {
    Route::controller(ResturantFrontController::class)->group(function () {
        Route::get('/', 'show')->name('restaurant.show');
    });

    Route::controller(MessageController::class)->group(function () {
        Route::get('contact', 'index')->name('contact');
        Route::match(['get', 'post'], 'contact/sendmessage', 'store')->name('contact.store');
    });
    Route::controller(CartController::class)->group(function () {
        Route::get('cart', 'cart');
        // Route::match(['post','get'],'cart/add', 'add');
        Route::post('/cart/add', 'add')->name('cart.add');
        Route::get('/cart/items', 'getCartItems');
        Route::post('cart/delete/{id}', 'delete')->name('cart.delete');
        Route::post('/cart/update', 'updateCart')->name('cart.update');
        Route::post('apply_coupon', 'apply_coupon');
    });

    Route::controller(CheckoutController::class)->group(function () {
        Route::get('/check-login-status', 'checkLoginStatus')->name('check.login.status');

        Route::post('/send-verification-code', 'sendVerificationCode')->name('send.verification.code');
        Route::post('/verify-code', 'verifyCode')->name('verify.code');
    });


    // Route::group(['middleware' => 'auth'], function () {
        Route::controller(OrderController::class)->group(function () {
            Route::post('order/store', 'store')->name('order.store');
            Route::get('thanks', 'thanks')->name('thanks');
        });

        ////////////////////////// User Dashbpard
        Route::controller(UserController::class)->group(function () {
            Route::get('account', 'account')->name('account');
            Route::get('logout', 'logout')->name('user.logout');
        });
   // });
    // Route::group(['middleware' => 'auth'], routes: function () {
        Route::controller(CheckoutController::class)->group(function () {
            Route::get('checkout', 'checkout')->name('checkout');
            Route::get('/get-shipping-price', 'getShippingPrice');
            Route::get('select_area/{id}', 'selectArea')->name('select.area');
        });
    //});
});







Route::view('terms', 'front.terms');
Route::view('privacy-policy', 'front.privacy-policy');


@include 'dashboard.php';
