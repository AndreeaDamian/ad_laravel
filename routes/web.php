<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShopController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [ShopController::class, 'index'])->name('home');
Route::post('/cart', [ShopController::class, 'addToCart'])->name('add.cart');
Route::get('/cart', [ShopController::class, 'cart'])->name('cart');
Route::post('/cart/remove', [ShopController::class, 'removeItem'])->name('cart.remove');
Route::post('/checkout', [ShopController::class, 'checkout'])->name('checkout');

Auth::routes();
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::middleware('auth')->group(function () {
    Route::resources([
        'products' => ProductController::class,
        'orders' => OrderController::class,
    ]);
});

Route::get('/spa', function (){
    return view('spa.index');
});

Route::get('{any}', function () {
    return view('spa.index-vue');
})->where('any', '.*');




