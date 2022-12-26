<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorCotroller;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentMethodController;
use App\Http\Controllers\PhoneController;
use App\Http\Controllers\PhoneDetailController;
use App\Http\Controllers\RamController;
use App\Http\Controllers\RomController;
use App\Http\Controllers\ShipMethodController;
use App\Http\Controllers\StatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Ram API
Route::controller(RamController::class)->group(function () {
    Route::get('/ram', 'index');
    Route::get('/ram/{id}', 'show');
    Route::get('/ram/{id}/restore', 'restore');
    Route::get('/ram/restore', 'restoreAll');
    Route::post('/ram', 'store');
    Route::post('/ram/search', 'search');
    Route::post('/ram/delete/{id}', 'delete');
    Route::put('/ram/{id}', 'update');
    // Route::delete('/phone/{id}', 'update');
});

// Rom API
Route::controller(RomController::class)->group(function () {
    Route::get('/rom', 'index');
    Route::get('/rom/{id}', 'show');
    Route::get('/rom/{id}/restore', 'restore');
    Route::get('/rom/restore', 'restoreAll');
    Route::post('/rom', 'store');
    Route::post('/rom/search', 'search');
    Route::post('/rom/delete/{id}', 'delete');
    Route::put('/rom/{id}', 'update');
    // Route::delete('/phone/{id}', 'update');
});

// Color API
Route::controller(ColorCotroller::class)->group(function () {
    Route::get('/color', 'index');
    Route::get('/color/{id}', 'show');
    Route::get('/color/{id}/restore', 'restore');
    Route::get('/color/restore', 'restoreAll');
    Route::post('/color', 'store');
    Route::post('/color/search', 'search');
    Route::post('/color/delete/{id}', 'delete');
    Route::put('/color/{id}', 'update');
    // Route::delete('/phone/{id}', 'update');
});


// Phone API
Route::controller(PhoneController::class)->group(function () {
    Route::get('/phone', 'index');
    Route::get('/phone/{id}', 'show');
    Route::get('/phone/{id}/restore', 'restore');
    Route::get('/phone/restore', 'restoreAll');
    Route::post('/phone', 'store');
    Route::post('/phone/search', 'search');
    Route::post('/phone/delete/{id}', 'delete');
    Route::put('/phone/{id}', 'update');
    // Route::delete('/phone/{id}', 'update');
});


// Phone Detail API
Route::controller(PhoneDetailController::class)->group(function () {
    Route::get('/phoneDetail', 'index');
    Route::get('/phoneDetail/{id}', 'show');
    Route::get('/phoneDetail/{id}/restore', 'restore');
    Route::get('/phoneDetail/restore', 'restoreAll');
    Route::post('/phoneDetail', 'store');
    Route::post('/phoneDetail/search', 'search');
    Route::post('/phoneDetail/delete/{id}', 'delete');
    Route::put('/phoneDetail/{id}', 'update');
    // Route::delete('/phone/{id}', 'update');
});


// Ship API
Route::controller(ShipMethodController::class)->group(function () {
    Route::get('/ship', 'index');
    Route::get('/ship/{id}', 'show');
    Route::get('/ship/{id}/restore', 'restore');
    Route::get('/ship/restore', 'restoreAll');
    Route::post('/ship', 'store');
    Route::post('/ship/search', 'search');
    Route::post('/ship/delete/{id}', 'delete');
    Route::put('/ship/{id}', 'update');
    // Route::delete('/phone/{id}', 'update');
});

// Payment API
Route::controller(PaymentMethodController::class)->group(function () {
    Route::get('/payment', 'index');
    Route::get('/payment/{id}', 'show');
    Route::get('/payment/{id}/restore', 'restore');
    Route::get('/payment/restore', 'restoreAll');
    Route::post('/payment', 'store');
    Route::post('/payment/search', 'search');
    Route::post('/payment/delete/{id}', 'delete');
    Route::put('/payment/{id}', 'update');
    // Route::delete('/phone/{id}', 'update');
});

// CartItem API
Route::controller(CartItemController::class)->group(function () {
    Route::get('/cart', 'index');
    Route::get('/cart/customer/{id}', 'show');
    Route::post('/cart', 'store');
    Route::delete('/cart/delete/{id}', 'delete');
    Route::put('/cart', 'update');
});


// Order API
Route::controller(OrderController::class)->group(function () {
    Route::get('/order', 'index');
    Route::get('/order/{id}', 'show');
    Route::post('/order', 'store');
    Route::put('/order/{id}', 'update');
    Route::delete('/order/{id}', 'destroy');
});



// Customer API
Route::controller(CustomerController::class)->group(function () {
    Route::get('/customer', 'index');
    Route::get('/customer/{id}', 'show');
    Route::get('/customer/{id}/restore', 'restore');
    Route::get('/customer/restore', 'restoreAll');
    Route::post('/customer', 'store');
    Route::post('/customer/login', 'login');
    Route::post('/customer/register', 'register');
    Route::post('/customer/search', 'search');
    Route::post('/customer/delete/{id}', 'delete');
    Route::put('/customer/{id}', 'update');
    // Route::delete('/phone/{id}', 'update');
});

// Satus API
Route::controller(StatusController::class)->group(function () {
    Route::get('/status', 'index');
    Route::get('/status/{id}', 'show');
    Route::get('/status/{id}/restore', 'restore');
    Route::get('/status/restore', 'restoreAll');
    Route::post('/status', 'store');
    Route::post('/status/search', 'search');
    Route::post('/status/delete/{id}', 'delete');
    Route::put('/status/{id}', 'update');
    // Route::delete('/phone/{id}', 'update');
});

// Satus API
Route::controller(CategoryController::class)->group(function () {
    Route::get('/category', 'index');
    Route::get('/category/{id}', 'show');
    Route::get('/category/{id}/restore', 'restore');
    Route::get('/category/restore', 'restoreAll');
    Route::post('/category', 'store');
    Route::post('/category/search', 'search');
    Route::post('/category/delete/{id}', 'delete');
    Route::put('/category/{id}', 'update');
    // Route::delete('/phone/{id}', 'update');
});

