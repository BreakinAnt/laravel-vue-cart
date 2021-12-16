<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


$a = [
    [
        'id' => 1,
        'name' => 'Produto A',
        'value' => 2500
    ],
    [
        'id' => 2,
        'name' => 'Produto B',
        'value' => 3000
    ],
    [
        'id' => 3,
        'name' => 'Produto C',
        'value' => 1599
    ],
    [
        'id' => 4,
        'name' => 'Produto D',
        'value' => 1755
    ]
];

Route::get('/product/all', function (Request $request) use ($a) {

    return [$a];
});

Route::get('/product', function (Request $request) use ($a) {
    return ['product' => $a[$request->id-1]];
});