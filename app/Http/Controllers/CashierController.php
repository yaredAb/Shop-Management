<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class CashierController extends Controller
{
    public function index()
    {
        $sales = Sale::where('status', 'pending')->with('pharmacist')->orderBy('created_at', 'desc')->get();
        return view('cashier.index', compact('sales'));
    }
}
