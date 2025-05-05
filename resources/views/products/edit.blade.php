@extends('layouts.app')

@section('content')

    <div class="form-container">
        <div class="form-wrapper">
            <h2>Edit Product</h2>
            <form action="{{route('products.update', $product)}}" method="POST">
                @csrf
                @method('PUT')
                <p>Name:</p>
                <input type="text" name="name" value="{{ $product->name }}" required>
                <p>Bought Price:</p>
                <input type="number" step="0.01" name="bought_price" value="{{ $product->bought_price }}" required>
                <p>Sale Price:</p>
                <input type="number" step="0.01" name="sale_price" value="{{$product->sale_price}}" required>
                <p>Quantity:</p>
                <input type="number" name="quantity" value="{{$product->quantity}}" required>
                <p>Category:</p>
                <select name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit">Save</button>
            </form>
        </div>
    </div>
@endsection
