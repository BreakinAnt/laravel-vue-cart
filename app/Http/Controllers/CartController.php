<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    public function __construct()
    {
        $this->a = [
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
    }

    public function index()
    {
        $DATA = ['cookie'];
        
        $cookie = Cookie::get('cart');

        return view('cart', compact($DATA));
    }

    public function addToCart()
    {
        $cartData = json_encode([
            ['id' => 1, 'quant' => 1],
            ['id' => 2, 'quant' => 4],
            ['id' => 3, 'quant' => 4],
            ['id' => 4, 'quant' => 2],
        ]);
    
        $cookie = Cookie::make('cart', $cartData);  
        Cookie::queue($cookie);
    
        return redirect()->route('app.cart');
    }

    public function removeFromCart(Request $req)
    {
        $cookie = json_decode(Cookie::get('cart'));

        if($cookie[$req->index]->id == $req->id){
            unset($cookie[$req->index]);
            $cookie = array_values($cookie);
        }
    
        $cookie = Cookie::make('cart', json_encode($cookie)); 
        Cookie::queue($cookie);
    
        return redirect()->route('app.cart');
    }

    public function checkoutCart(Request $req)
    {
        $DATA = ['checkout', 'prod'];

        $cookie = Cookie::forget('cart');
        Cookie::queue($cookie);
        
        $checkout = $req->all();
        $prod = $this->a;
        
        return view('checkout', compact($DATA));
    }
}
