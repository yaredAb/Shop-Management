@if(session('cart') && count(session('cart')) > 0)

    @php
        $cart = session('cart', []);
    @endphp

    @if (count($cart) > 0)
        @foreach ($cart as $id=>$item)
            <div class="cart-product">

                <div class="flex gap-1 items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="delete-item" data-id="{{$id}}" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-circle-x-icon lucide-circle-x"><circle cx="12" cy="12" r="10"/><path d="m15 9-6 6"/><path d="m9 9 6 6"/></svg>
                    <p class="cart-name">{{$item['name']}} @if (!empty($item['country'])) ({{$item['country']}}) @endif</p>
                </div>
                <div class="price-section">

                    <button class="decrease-qty bg-gray-200 rounded" data-id="{{$id}}">-</button>
                    <span>{{$item['quantity']}}</span>
                    <button class="increase-qty rounded @if($item['quantity'] >= $item['stock']) bg-white @else bg-gray-200 @endif" data-id="{{$id}}">+</button>
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

        <div class="flex gap-2 w-full">
            <form action="{{route('checkout')}}" method="POST">
                @csrf
                <button type="submit" class="bg-blue-500 text-lg text-white px-3 py-2 rounded">Send to cashier</button>
            </form>

            @if(auth()->user()->privilage == 'admin')
                <form action="{{route('proceed.direct')}}" method="POST">
                    @csrf
                    <button type="submit" class="bg-green-600 text-lg text-white px-3 py-2 rounded">Proceed</button>
                </form>
            @endif
        </div>

    @else
        <p>No product in the cart</p>
    @endif

@endif
