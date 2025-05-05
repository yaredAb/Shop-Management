<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <div class="wrapper">
        <nav>
            <a href="#" class="logo">SHOP</a>
            <ul class="nav-links">
                <li><a href="{{route('products.index')}}">Shop</a></li>
                <li><a href="{{route('products.create')}}">Add Product</a></li>
                <li><a href="{{route('categories.create')}}">Add Category</a></li>
                <li><a href="{{route('sales.report')}}">Report</a></li>
                <li><a href="#">Settings</a></li>
            </ul>
        </nav>
        @yield('content')
    </div>
    @yield('scripts')
</body>
</html>
