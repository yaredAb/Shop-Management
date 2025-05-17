<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function list() {
        $cart = session('cart', []);
        return view('cart.list', ['cart' => $cart]);
    }
}
