@if(session('cart') && count(session('cart')) > 0)

    @php
        $cart = session('cart', []);
    @endphp

    @if (count($cart) > 0)
        @foreach ($cart as $id=>$item)
            <div class="cart-product">
                <p class="cart-name">{{$item['name']}}</p>
                <div class="price-section">

                    <button class="decrease-qty" data-id="{{$id}}">-</button>
                    <span>{{$item['quantity']}}</span>
                    <button class="increase-qty" data-id="{{$id}}" @if($item['quantity'] >= $item['stock']) disabled @endif>+</button>
                    <span> x {{number_format($item['price'])}} = {{number_format($item['price'] * $item['quantity'])}}</span>

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
            <p class="total-cart">Total: {{number_format($total)}} Birr</p>
        </div>

        <form action="{{route('checkout')}}" method="POST">
            @csrf
            <button type="submit" class="purchase-btn">Purchase</button>
        </form>

    @else
        <p>No product in the cart</p>
    @endif

@endif
