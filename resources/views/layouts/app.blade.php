@extends('layouts.clean')

@section('childContent')
    <div class="wrapper">
        @include('components.navigation')

        @yield('content')
    </div>

    @yield('script')
@endsection

@section('scripts')
    <script>

        const toggle_button = document.getElementById('toggle-menu')
        const menu_container = document.querySelector('.nav-links')

        let isMenuOpen = false
        toggle_button.addEventListener('click', () => {
            isMenuOpen = !isMenuOpen

            menu_container.classList.toggle('open', isMenuOpen)
            toggle_button.src = isMenuOpen ? "{{asset('img/cancel2.png')}}" : "{{asset('img/menu2.png')}}";
        })


        const toggle_cart = document.getElementById('toggleCart')
        const cart_container = document.querySelector('.mobile-cart')

        let isCartOpen = false
        toggle_cart.addEventListener('click', () => {
            isCartOpen = !isCartOpen

            cart_container.classList.toggle('open')
            toggle_cart.style.transform = isCartOpen ? 'rotate(0deg)' : 'rotate(180deg)'
        })

    </script>
@endsection


