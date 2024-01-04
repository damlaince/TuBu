<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/test', [\App\Http\Controllers\TestController::class, 'test']);

Route::group(['prefix' => 'panel', 'as' => 'panel.'], function () {
    Route::match(['get', 'post'], '/login', [\App\Http\Controllers\backend\AuthController::class, 'index'])->middleware('guest')->name('login');

    Route::group(['middleware' => 'auth'], function () {
        Route::get('/logout', [\App\Http\Controllers\backend\AuthController::class, 'logout'])->name('logout');
        Route::get('/dash', [\App\Http\Controllers\backend\DashboardController::class, 'index'])->name('dash');
        // Categories
        Route::get('/categories', [\App\Http\Controllers\backend\CategoryController::class, 'index'])->name('category.list');
        Route::match(['get', 'post'], '/category/{id?}', [\App\Http\Controllers\backend\CategoryController::class, 'form'])->name('category.form');

        // products
        Route::get('/products', [\App\Http\Controllers\backend\ProductController::class, 'index'])->name('product.list');
        Route::match(['get', 'post'], '/product/form/{id?}', [\App\Http\Controllers\backend\ProductController::class, 'form'])->name('product.form');

        // order
        Route::get('/orders', [\App\Http\Controllers\backend\OrderController::class, 'index'])->name('order.list');
        Route::match(['get','post'], '/order/detail/{id}',[\App\Http\Controllers\backend\OrderController::class, 'detail'])->name('order.detail');
    });
});

Route::group(['as' => 'front.'], function () {

    Route::match(['get', 'post'], '/login', [\App\Http\Controllers\frontend\AuthController::class, 'index'])->middleware('guestfront')->name('login');
    Route::match(['get', 'post'], '/register', [\App\Http\Controllers\frontend\AuthController::class, 'register'])->middleware('guestfront')->name('register');
    Route::group(['middleware' => 'authfront'], function () {
        Route::get('/', [\App\Http\Controllers\frontend\HomeController::class, 'index'])->name('home');
        Route::get('/logout', [\App\Http\Controllers\frontend\AuthController::class, 'logout'])->name('logout');
        Route::match(['get','post'],'/product/{category}/{altcategory?}',[\App\Http\Controllers\frontend\ProductController::class,'index'])->name('product.list');
        Route::match(['get','post'], '/product/{category}/{altcategory}/{id}',[\App\Http\Controllers\frontend\ProductController::class,'detail'])->name('product.detail');
        Route::post('/save/{category}/{altcategory?}/{id?}', [\App\Http\Controllers\frontend\ProductController::class, 'cartSave'])->name('product.save');

        Route::match(['get','post'], '/cart',[\App\Http\Controllers\frontend\OrderController::class,'index'])->name('cart');
        Route::match(['get','post'], '/payment',[\App\Http\Controllers\frontend\OrderController::class,'payment'])->name('payment');

        // Siparişlerim
        Route::get('/order/list', [\App\Http\Controllers\frontend\OrderController::class, 'list'])->name('order.list');
    });
});
