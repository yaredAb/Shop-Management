@extends('layouts.app')
@php
$cart = session('cart', []);
@endphp

@section('content')
    <div class="items-container">
        <h1>Cart</h1>
        <hr>
        <div class="cart-body-wrapper">
{{--            @if(count($cart) > 0)--}}
{{--                @foreach($cart as $id=>$item)--}}
{{--                    <div class="cart-body">--}}
{{--                        <p>{{$item['name']}}</p>--}}
{{--                        <div class="cart-qty">--}}
{{--                            <button class="decrease-qty" data-id="{{$id}}" data-action="decrease">-</button>--}}
{{--                            <span>{{$item['quantity']}}</span>--}}
{{--                            <button class="increase-qty" data-id="{{$id}}" data-action="increase" @if($item['quantity'] >= $item['stock']) disabled @endif>+</button>--}}
{{--                            <span> x {{number_format($item['price'])}} = {{number_format($item['price'] * $item['quantity'])}}</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--                <hr>--}}
{{--                @php--}}
{{--                    $cart = session('cart', []);--}}
{{--                    $total = 0;--}}
{{--                    foreach ($cart as $item) {--}}
{{--                        $total += $item['price'] * $item['quantity'];--}}
{{--                    }--}}
{{--                @endphp--}}

{{--                <p class="total-cart">Total: {{number_format($total)}} Birr</p>--}}
{{--                <form action="{{route('checkout')}}" method="POST">--}}
{{--                    @csrf--}}
{{--                    <button type="submit" class="purchase">Purchase</button>--}}
{{--                </form>--}}
{{--                <hr>--}}
{{--                <p class="total-cart"></p>--}}

{{--            @else--}}
{{--                <p class="message">Your cart is empty.</p>--}}
{{--            @endif--}}

            <div id="cart-section">
                @foreach($cart as $id=>$item)
                    <div class="cart-body">
                        <p>{{$item['name']}}</p>
                        <div class="cart-qty">
                            <button class="decrease-qty" data-id="{{$id}}" data-action="decrease">-</button>
                            <span>{{$item['quantity']}}</span>
                            <button class="increase-qty" data-id="{{$id}}" data-action="increase"
                                    @if($item['quantity'] >= $item['stock']) disabled @endif>+</button>
                            <span> x {{number_format($item['price'])}} = {{number_format($item['price'] * $item['quantity'])}}</span>
                        </div>
                    </div>
                @endforeach
                {{-- Total and Checkout here --}}
            </div>


        </div>
    </div>
@endsection
@section('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
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
                    $('#cart-section').html(response.cart_html);
                    $('.cart_count').fadeOut(150, function() {
                        $(this).text(response.cart_count).fadeIn(150)
                    });
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
