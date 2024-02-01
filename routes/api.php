<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api.key')->group(function() {
    Route::prefix('/auth' )->group(function () {
        Route::post('/register', [AuthController::class, 'register'])->name('register');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    });
    Route::prefix('/contact')->group(function () {
        Route::get('/all', [ContactController::class, 'index'])->name('contact.all');
        Route::get('/create', [ContactController::class, 'create'])->name('contact.create');
        Route::post('/store', [ContactController::class, 'store']);
        Route::get('/edit/{id}', [ContactController::class, 'edit'])->name('contact.edit');
        Route::post('/update/{id}', [ContactController::class, 'update']);
        Route::get('/delete/{id}', [ContactController::class, 'destroy'])->name('contact.delete');
    });
    Route::prefix('news')->group(function () {
        Route::get('/all', [NewsController::class, 'all'])->name('news.all');
        Route::get('/detail-{name}', [NewsController::class, 'show'])->name('news.detail');
    });
    Route::prefix('product')->group(function () {
        Route::get('/all', [ProductController::class, 'all'])->name('product.all');
        Route::get('/detail-{name}', [ProductController::class, 'detail'])->name('product.detail');
    });
    Route::post('/order-qty/{id}', [OrderController::class,'updateCart'])->name('cart.updateCart');
    Route::post('/postAddress-{id}', [AddressController::class,'store'])->name('order.postAddress');
    Route::post('/remove-from-cart/{id}', [CartController::class,'removeFromCart'])->name('cart.delete');
    Route::post('/add-to-cart/{id}', [CartController::class,'addToCart'])->name('cart.add');
    Route::post('/add-order', [CartController::class,'order'])->name('order.store');
    Route::get('/delete-order/{id}', [OrderController::class,'destroy'])->name('order.delete');
    Route::post('/cost-{name}', [OrderController::class,'postCost'])->name('order.postCost');
});
