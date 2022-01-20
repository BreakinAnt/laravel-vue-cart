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

use App\Http\Controllers\CartController;
use App\Http\Controllers\ListController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

Route::get('/cart', [CartController::class, 'index'])->name('app.cart');
Route::get('/cart/add', [CartController::class, 'addToCart']);
Route::get('/cart/remove', [CartController::class, 'removeFromCart'])->name('app.cart.remove');
Route::post('/cart/checkout', [CartController::class, 'checkoutCart'])->name('app.cart.checkout');

Route::get('/list', [ListController::class, 'index'])->name('app.list');
Route::post('/list', [ListController::class, 'saveList'])->name('app.list.post');