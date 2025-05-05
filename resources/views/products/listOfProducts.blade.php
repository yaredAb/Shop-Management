@extends('layouts.app')

@section('content')

    <div class="cat-header">
        <h1>All Products</h1>
        <a href="{{route('products.create')}}">Add New Product</a>
    </div>

    @if(session('success'))
        <div>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div>
            {{ session('error') }}
        </div>
    @endif

    <table class="order-table">
        <thead>
            <tr>
                <th>Product</th>
                <th>Category</th>
                <th>Quantity</th>
                <th>BoughtPrice</th>
                <th>Sale Price</th>
                <th>Created at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->category->name }}</td>
                    <td>{{ $product->quantity }}</td>
                    <td>{{ $product->bought_price }} Birr</td>
                    <td>{{ $product->sale_price }} Birr</td>
                    <td>{{ \Carbon\Carbon::parse($product->created_at)->format('F d, Y') }}</td>
                    <td class="actions">
                        <a href="{{route('products.edit', $product)}}" class="editBtn">Edit</a>

                        <form action="{{route('products.destroy', $product)}}" method="POST">
                            @method('DELETE')
                            @csrf

                            <button class="deleteBtn" onclick="confirm('Are you sure you want to delete this product?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
@endsection