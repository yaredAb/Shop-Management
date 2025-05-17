@php
$cart = session('cart', []);
@endphp

<nav>
    <a href="/" class="logo">{{$site_title}}</a>
    <div class="icon-container">
        <a href="{{route('cart.list')}}" class="cartContainer">
            <img src="{{asset('./img/cart.png')}}" class="cart" alt="Cart">
            <span class="cart_count">{{count($cart)}}</span>
        </a>
        <img src="{{asset('./img/menu2.png')}}" id="toggle-menu" alt="">
    </div>
    <ul class="nav-links">
        <li><a href="{{route('products.index')}}">Shop</a></li>
        <li><a href="{{route('products.create')}}">Add Product</a></li>
        <li><a href="{{route('categories.create')}}">Add Category</a></li>
        <li><a href="{{route('products.list')}}">Products</a></li>
        @if ($user_role === 'admin')
            <li><a href="{{route('categories.index')}}">Categories</a></li>
            <li><a href="{{route('userList')}}">Users</a></li>
            <li><a href="{{route('sales.report')}}">Report</a></li>
            <li><a href="{{route('sale.index')}}">All Orders</a></li>
            <li><a href="{{route('settings')}}">Settings</a></li>
        @endif
    </ul>
</nav>
