@extends('layouts.app')

@section('content')
    <div class="total-sale">
        <h2>Today's Sale: <span>{{number_format($todaySale)}} Birr</span></h2>
        <p>{{now()->format('M d, Y')}}</p>
    </div>

    <div class="filtering-section">
        <form action="{{route('products.index')}}" method="GET" class="search-form">
            <input type="search" name="product_name" placeholder="Search Product....">
        </form>

        <form action="{{route('products.index')}}" method="GET" class="categories">
            <input type="hidden" name="product_name" value="{{request('product_name')}}">
            <button type="submit" name="category_id" value="">All</button>
            @foreach ($categories as $category)
                <button name="category_id" value="{{$category->id}}">{{$category->name}}</button>
            @endforeach
        </form>
    </div>

    <div class="product-section">
        <div class="products-wrapper">
            <div class="products-row">
                @foreach ($products as $product)
                    <div class="product">
                        @if ($product->category && $product->category->image)
                            <img src="{{asset('storage/'. $product->category->image)}}" alt="{{$product->name}}">
                        @else
                            <div class="no-image">
                                <h3>{{$product->name}}</h3>
                            </div>
                        @endif

                        <p>{{$product->name}}</p>

                        <div class="stock-quantity">
                            <span><strong>QTY: </strong>{{$product->quantity}}</span>
                            @if ($product->quantity <= $product->stock_threshold)
                                <span class="low-stock">Low Stock!</span>
                            @endif
                        </div>

                            @php
                                $status = \App\Helper\DateHelper::expiryStatus($product->expiry_date);
                            @endphp
                            @if($product->has_expiry && $product->expiry_date)
                                <span
                                @class([
                                    'text-red-700 font-bold' => $status === 'expired',
                                    'text-orange-400 font-bold' => $status === 'near',
                                    'text-green-700 font-bold' => $status === 'far'
                                ])>
                                {{\App\Helper\DateHelper::expiryRemaining($product->expiry_date)}}
                            </span>
                            @endif


                        <span class="price-section">{{number_format($product->sale_price)}} Birr</span>
{{--                        <form action="{{route('cart.add', $product->id)}}" method="POST">--}}
{{--                            @csrf--}}
                            <button class="add-to-cart cursor-pointer" data-id="{{$product->id}}">Add to cart</button>
{{--                        </form>--}}
                    </div>
                @endforeach
            </div>
        </div>

        <div class="cart-container">
            <h2>Cart</h2>
            <div class="cart-products" id="cart-section">
                @include('partials.cart', ['cart' => session('cart', [])])
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).on('click', '.add-to-cart', function(e) {
            e.preventDefault();

            var productId = $(this).data('id');

            $.ajax({
                url: '/add-to-cart/' + productId,
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {

                    $('#cart-section').html(response.cart_html);
                },
                error: function (xhr) {
                    alert('Something went wrong')
                }
            })
        })

        $(document).on('click', '.increase-qty', function () {
            let productId = $(this).data('id');
            updateQty(productId, 'increase');
        });

        $(document).on('click', '.decrease-qty', function () {
            let productId = $(this).data('id');
            updateQty(productId, 'decrease');
        });

        function updateQty(productId, action) {
            $.ajax({
                url: '/cart/update/',
                method: 'POST',
                data: {
                    _token: '{{csrf_token()}}',
                    id: productId,
                    action: action
                },
                success: function (response) {
                    $('#cart-section').html(response.cart_html)
                },
                error: function (xhr) {
                    if(xhr.responseJson && xhr.responseJson.error){
                        alert(xhr.responseJson.error);
                    } else{
                        alert('Failed to update cart');
                    }
                }
            })
        }

    </script>
@endsection

