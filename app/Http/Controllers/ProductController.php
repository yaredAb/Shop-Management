<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Log;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Setting;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $products = Product::with('category')
            ->where('quantity', '>', 0)
            ->orderBy('created_at', 'desc');

        //applying search
        if($request->filled('product_name')) {
            $products->where('name', 'like', '%'. $request->product_name . '%');
        }

        //category filter
        if($request->filled('category_id')) {
            $products->where('category_id', $request->category_id);
        }

        $todaysSale = Sale::whereDate('sold_at', today())->sum(DB::raw('price * quantity'));

        return view('products.index', [
            'products' => $products->get(),
            'categories' => Category::all(),
            'todaySale' => $todaysSale
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->merge([
            'has_expiry' => $request->has('has_expiry')
        ]);
        $request->validate([
            'name' => 'required',
            'bought_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'stock_threshold' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'has_expiry' => 'nullable|boolean',
            'expiry_date' => 'nullable|date|required_if:has_expiry, true',
            'country' => 'nullable',
        ]);

        Product::create([
            'name' => $request->name,
            'bought_price' => $request->bought_price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'stock_threshold' => $request->stock_threshold,
            'category_id' => $request->category_id,
            'has_expiry' => $request->has('has_expiry'),
            'expiry_date' => $request->has('has_expiry') ? $request->expiry_date : null,
            'country' => $request->country
        ]);

        return redirect()->route('products.index')->with('success', 'Product created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('categories', 'product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->merge([
            'has_expiry' => $request->has('has_expiry')
        ]);
        $request->validate([
            'name' => 'required',
            'bought_price' => 'required|numeric',
            'sale_price' => 'required|numeric',
            'quantity' => 'required|integer',
            'stock_threshold' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'has_expiry' => 'nullable|boolean',
            'expiry_date' => 'nullable|date|required_if:has_expiry, true',
            'country' => 'nullable',
        ]);


        $product->update([
            'name' => $request->name,
            'bought_price' => $request->bought_price,
            'sale_price' => $request->sale_price,
            'quantity' => $request->quantity,
            'stock_threshold' => $request->stock_threshold,
            'category_id' => $request->category_id,
            'has_expiry' => $request->has('has_expiry'),
            'expiry_date' => $request->has('has_expiry') ? $request->expiry_date : null,
            'country' => $request->country
        ]);

        Log::saveLog('green', 'A product '. $request->name . 'has been updated');
        return redirect()->route('products.index')->with('success', 'Product updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        Log::saveLog('red', 'A product '. $product->name . 'has been deleted');
        return redirect()->back()->with('success', 'Product deleted ');
    }

    public function addToCart(Request $request, Product $product) {
        $cart = session()->get('cart', []);

        if(isset($cart[$product->id])) {
            $cart[$product->id]['quantity']+=1;
        }
        else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->sale_price,
                'quantity' => 1,
                'stock' => $product->quantity
            ];
        }

        session()->put('cart', $cart);

        //return redirect()->back()->with('success', "{$product->name} added to cart");
        $cartHtml = view('partials.cart', ['cart' => $cart])->render();

        return response()->json([
            'message' => "{$product->name} added to cart",
            'cart_html' => $cartHtml
        ]);
    }

    public function  updateQuantity(Request $request)
    {
        $cart = session('cart', []);
        $id = $request->input('id');
        $action = $request->input('action');

        if(isset($cart[$id])) {
            if($action == 'increase') {
                if ($cart[$id]['quantity'] < $cart[$id]['stock']) {
                    $cart[$id]['quantity'] += 1;
                } else{
                    return \response()->json([
                        'error' => 'Cannot add morethan avaliable stock',
                        'cart_html' => view('partials.cart', ['cart' => $cart])->render()
                    ], 400);
                }

            } else if($action == 'decrease') {
                if($cart[$id]['quantity'] > 1) {
                    $cart[$id]['quantity'] -= 1;
                } else{
                    unset($cart[$id]);
                }
            }
            session(['cart' => $cart]);
        }

        return response()->json([
            'cart_html' => view('partials.cart', ['cart' => $cart])->render()
        ]);
    }

    public function completeSale() {
        $cart = session('cart', []);

        if(empty($cart)) {
            return redirect()->back()->with('error', 'Cart is empty');
        }

        DB::beginTransaction();
        try {
            foreach ($cart as $productId=>$item) {
                Sale::create([
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'sold_at' => now()
                ]);

                $product = Product::findOrFail($productId);
                $product->decrement('quantity', $item['quantity']);

                $updatedProduct = Product::find($productId);
                $message = "⚠️ Low Stock Alert!\nProduct: {$updatedProduct->name}\nRemaining: {$updatedProduct->quantity}";
                try{
                    if($updatedProduct->quantity <= $updatedProduct->stock_threshold) {
                        \App\Helper\TelegramHelper::sendTelegramMessage($message);
                    }

                } catch(\Exception $e) {
                    log_to_db('error', 'Telegram alert failed');
                }

            }

            DB::commit();

            session()->forget('cart');
            Log::saveLog('green', 'Sale Completed');
            return redirect()->route('product.index')->with('success', 'Sale recorded successfully');
        }catch(\Exception $e) {
            DB::rollBack();
            Log::saveLog('red', 'Failed to complete sale');
            return redirect()->back()->with('error', 'Failed to complete sale.');
        }
    }


    public function listOfProducts() {
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('products.listOfProducts', compact('products'));
    }
}
