<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function list() {
        $cart = session('cart', []);
        return view('cart.list', ['cart' => $cart]);
    }

    public function delete_cart_item(Request $request)
    {
        $cart = session('cart', []);
        $id = $request->input('id');

        if(isset($cart[$id])){
            unset($cart[$id]);
            session()->put('cart', $cart);
            return response()->json([
                'cart_html' => view('partials.cart', ['cart' => $cart])->render(),
                'cart_count' => count($cart),
            ]);
        }
        return response()->json(['error' => 'Item not found in cart.'], 404);

    }
}
