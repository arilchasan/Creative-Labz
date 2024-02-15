<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PromoController;
use App\Http\Controllers\AddressController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\RajaOngkirController;
use App\Http\Controllers\Api\ContactController;


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

Route::get('/', [HomeController::class,'index'])->name('home')->middleware('auth:admin');
Route::get('/login', [AuthController::class,'loginWeb'])->name('login');
Route::post('/login-admin', [AuthController::class,'postLogin'])->name('postLogin');
Route::get('/logout', [AuthController::class,'loggedOut'])->name('logout');

Route::prefix('/dashboard')->middleware('auth:admin')->group(function() {
    Route::get('/home', [HomeController::class,'home']);
    Route::get('/filterData', [HomeController::class,'filterData'])->name('filterData');
    Route::get('/filterProduct', [HomeController::class,'filterDataProduct'])->name('filterProduct');
    Route::get('/download-excel', [HomeController::class, 'downloadExcel'])->name('downloadExcel');
    Route::get('/download-excel-order', [HomeController::class, 'downloadExcelOrder'])->name('downloadExcelOrder');
     Route::prefix('/admin')->group(function() {
        Route::get('/all', [AdminController::class,'index'])->name('admin.all');
        Route::get('/create', [AdminController::class,'create'])->name('admin.create');
        Route::post('/store', [AdminController::class,'store'])->name('admin.store');
        Route::get('/edit/{id}', [AdminController::class,'edit'])->name('admin.edit');
        Route::post('/update/{name}', [AdminController::class,'update'])->name('admin.update');
        Route::get('/delete/{id}', [AdminController::class,'destroy'])->name('admin.delete');
    });
    Route::prefix('/user')->group(function() {
        Route::get('/all', [UserController::class,'index'])->name('user.all');
        Route::get('/create', [UserController::class,'create'])->name('user.create');
        Route::post('/store', [UserController::class,'store']);
        Route::get('/edit/{id}', [UserController::class,'edit'])->name('user.edit');
        Route::post('/update/{id}', [UserController::class,'update']);
        Route::get('/delete/{id}', [UserController::class,'destroy'])->name('user.delete');
    });
    Route::prefix('/contact')->group(function() {
        Route::get('/all', [ContactController::class,'index'])->name('contact.all');
        Route::get('/detail-{name}', [ContactController::class,'detail'])->name('contact.detail');
        Route::get('/create', [ContactController::class,'create'])->name('contact.create');
        Route::post('/store', [ContactController::class,'store']);
        Route::get('/edit-{name}', [ContactController::class,'edit'])->name('contact.edit');
        Route::post('/update-{name}', [ContactController::class,'update']);
        Route::get('/delete-{id}', [ContactController::class,'destroy'])->name('contact.delete');
    });
    Route::prefix('/news')->group(function() {
        Route::get('/all', [NewsController::class,'index'])->name('news.all');
        Route::get('/detail-{name}', [NewsController::class,'show'])->name('news.detail');
        Route::get('/create', [NewsController::class,'create'])->name('news.create');
        Route::post('/store', [NewsController::class,'store'])->name('news.store');
        Route::get('/edit-{name}', [NewsController::class,'edit'])->name('news.edit');
        Route::post('/update-{name}', [NewsController::class,'update'])->name('news.update');
        Route::get('/delete-{id}', [NewsController::class,'destroy'])->name('news.delete');
    });
    Route::prefix('/product')->group(function() {
        Route::get('/all', [ProductController::class,'index'])->name('product.all');
        Route::get('/detail-{name}', [ProductController::class,'show'])->name('product.detail');
        Route::get('/cart-{name}', [ProductController::class,'cart'])->name('product.cart');
        Route::get('/create', [ProductController::class,'create'])->name('product.create');
        Route::post('/store', [ProductController::class,'store'])->name('product.store');
        Route::get('/edit-{name}', [ProductController::class,'edit'])->name('product.edit');
        Route::post('/update-{name}', [ProductController::class,'update'])->name('product.update');
        Route::get('/delete-{id}', [ProductController::class,'destroy'])->name('product.delete');
    });
    Route::prefix('/cart')->group(function() {
        Route::post('/add/{id}', [CartController::class,'addToCart'])->name('cart.add');
        Route::get('/delete-{id}', [CartController::class,'removeFromCart'])->name('cart.delete');
        Route::get('/all', [CartController::class,'index'])->name('cart.all');
        Route::get('/detail-{id}', [CartController::class,'show'])->name('cart.detail');
        Route::post('/order-{id}', [CartController::class,'order'])->name('cart.order');
    });
    Route::prefix('/order')->group(function() {
        Route::get('/all', [OrderController::class,'index'])->name('order.all');
        Route::get('/detail-{name}', [OrderController::class,'show'])->name('order.detail');
        Route::get('/cost-{name}', [OrderController::class,'cost'])->name('order.cost');
        Route::post('/postCost-{id}', [OrderController::class,'postCost'])->name('order.postCost');
        Route::post('/updateCart-{id}', [OrderController::class,'updateCart'])->name('order.updateCart');
        Route::post('/postAddress-{id}', [AddressController::class,'store'])->name('order.postAddress');
        Route::get('/delete-order/{id}', [OrderController::class,'destroy'])->name('order.delete');
        Route::get('/payment-{id}', [OrderController::class,'payment'])->name('order.payment');
        Route::post('/postPayment-{id}', [OrderController::class,'updatePayment'])->name('order.postPayment');
        Route::get('/req-order', [OrderController::class,'reqOrder'])->name('order.reqOrder');
        Route::get('/resi-{name}', [OrderController::class,'resi'])->name('order.resi');
        Route::post('/postResi-{id}', [OrderController::class,'updateResi'])->name('order.updateResi');
        Route::post('/accept-order-{id}', [OrderController::class,'accPayment'])->name('order.acceptOrder');
        Route::post('/reject-order-{id}', [OrderController::class,'rejectPayment'])->name('order.rejectOrder');
        Route::post('/upload-transfer-{id}', [OrderController::class,'uploadTransfer'])->name('order.uploadTransfer');
        Route::get('/failed-detail-{id}', [OrderController::class,'detailFailed'])->name('order.detailFailed');
        Route::get('/success-detail-{id}', [OrderController::class,'detailSuccess'])->name('order.detailSuccess');
        Route::post('/pending-order-{id}', [OrderController::class,'pendingPayment'])->name('order.pendingPayment');
    });
    Route::prefix('promo')->group(function() {
        Route::get('/all', [PromoController::class,'index'])->name('promo.all');
        Route::get('/create', [PromoController::class,'create'])->name('promo.create');
        Route::post('/store', [PromoController::class,'store'])->name('promo.store');
        Route::get('/edit-{name}', [PromoController::class,'edit'])->name('promo.edit');
        Route::post('/update-{name}', [PromoController::class,'update'])->name('promo.update');
        Route::get('/delete-{id}', [PromoController::class,'destroy'])->name('promo.delete');
    });
});
Route::get('/get-provinces', [RajaOngkirController::class, 'getProvinces'])->name('getProvinces');
Route::get('/get-cities/{province_id}', [RajaOngkirController::class, 'getCities'])->name('getCities');
Route::get('/get-subdistricts/{city_id}', [RajaOngkirController::class, 'getSubdistricts']);
Route::get('/rajaongkir/cities-detail/{id}', [RajaOngkirController::class, 'CitiesDetail']);
