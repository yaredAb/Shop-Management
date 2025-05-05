@extends('layouts.app')

@section('content')
    <div class="total-sale">
        <h2>Todays Sale: <span>{{$todaySale}} Birr</span></h2>
        <p>{{now()->format('M d, Y')}}</p>
    </div>

    <div class="filtering-section">
        <form action="{{route('products.index')}}" method="GET" class="search-form">
            <input type="search" name="product_name" placeholder="Search Product....">
        </form>
        
        <div class="categories">
            <form action="{{route('products.index')}}" method="GET">
                <input type="hidden" name="product_name" value="{{request('product_name')}}">
                <button type="submit" name="category_id" value="">All</button>
                @foreach ($categories as $category)
                    <button name="category_id" value="{{$category->id}}">{{$category->name}}</button>
                @endforeach
            </form>
        </div>
    </div>

    <div class="product-section">
        <div class="products-wrapper">
            @if (session('success'))
                <div class="alert">{{session('success')}}</div>
            @endif
            @if (session('error'))
                <div class="alert">{{session('error')}}</div>
            @endif
            <div class="products-row">
                @foreach ($products as $product)
                    <div class="product">
                        @if ($product->category && $product->category->image)
                            <img src="{{asset('storage/'. $product->category->image)}}" alt="{{$product->name}}">
                        @endif
                        
                        <p>{{$product->name}}</p>
                        <div class="stock-quantity">
                            <span><strong>QTY: </strong>{{$product->quantity}}</span>
                            @if ($product->quantity <= $product->stock_threshold)
                                <span class="low-stock">Low Stock!</span>
                            @endif
                        </div>
                        <span>{{$product->sale_price}} Birr</span>
                        <form action="{{route('cart.add', $product->id)}}" method="POST">
                            @csrf
                            <button type="submit">Add to cart</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="cart-container">
            <h2>Cart</h2>
            <div class="cart-products">
                @php
                    $cart = session('cart', []);
                @endphp

                @if (count($cart) > 0)
                    @foreach ($cart as $id=>$item)
                        <div class="cart-product">
                            <p><strong>{{$item['name']}}</strong></p>
                            <div class="price-section">
                                <div class="price-section">
                                    <form action="{{ route('cart.decrease', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit">-</button>
                                    </form>
                                
                                    <span>{{ $item['quantity'] }}</span>
                                
                                    <form action="{{ route('cart.increase', $id) }}" method="POST">
                                        @csrf
                                        <button type="submit">+</button>
                                    </form>
                                
                                    <span> X {{$item['price']}}= {{ $item['quantity'] * $item['price'] }} Birr</span>
                                </div>                                
                            </div>
                        </div>
                    @endforeach

                    @php
                        
                        $total = 0;
                        foreach ($cart as $item) {
                            $total += $item['price'] * $item['quantity'];
                        }
                    @endphp
                    <div class="cart-total">
                        <hr>
                        <p><strong>Total: {{$total}} Birr</strong></p>
                    </div>

                    <form action="{{route('checkout')}}" method="POST">
                        @csrf
                        <button type="submit">Done Purchase</button>
                    </form>
                        
                    @else
                        <p>No product in the cart</p>
                @endif
            </div>
        </div>
    </div>
@endsection