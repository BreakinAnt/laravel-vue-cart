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

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

$a = [
    1 => [
        'id' => 1,
        'name' => 'Produto A',
        'value' => 2500
    ],
    2 => [
        'id' => 2,
        'name' => 'Produto B',
        'value' => 3000
    ],
    3 => [
        'id' => 3,
        'name' => 'Produto C',
        'value' => 1599
    ],
    4 => [
        'id' => 4,
        'name' => 'Produto D',
        'value' => 1755
    ]
];

Route::get('/', function () {
    $DATA = ['cookie'];

    $cartData = json_encode([
        ['id' => 1, 'quant' => 1],
        ['id' => 3, 'quant' => 4],
        ['id' => 4, 'quant' => 2],
    ]);

    $cookie = Cookie::get('cart');

    return view('cart', compact($DATA));
})->name('app.cart');


Route::get('/cart/add', function () {
    $cartData = json_encode([
        ['id' => 1, 'quant' => 1],
        ['id' => 2, 'quant' => 4],
        ['id' => 3, 'quant' => 4],
        ['id' => 4, 'quant' => 2],
    ]);

    $cookie = Cookie::make('cart', $cartData);  
    Cookie::queue($cookie);

    return redirect()->route('app.cart');
});

Route::get('/cart/remove', function (Request $req) {
    $cookie = json_decode(Cookie::get('cart'));

    if($cookie[$req->index]->id == $req->id){
        unset($cookie[$req->index]);
        $cookie = array_values($cookie);
    }

    $cookie = Cookie::make('cart', json_encode($cookie)); 
    Cookie::queue($cookie);

    return redirect()->route('app.cart');
})->name('app.cart.remove');

Route::post('/cart/checkout', function (Request $req) use ($a) {
    $DATA = ['checkout', 'prod'];

    $cookie = Cookie::forget('cart');
    // Cookie::queue($cookie);
    
    $checkout = $req->all();
    $prod = $a;
    
    return view('checkout', compact($DATA));
})->name('app.cart.checkout');
