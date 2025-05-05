@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Product</h2>

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>Product Name</label><br>
            <input type="text" name="name" value="{{ $product->name }}" required style="width:100%; padding:8px; margin-bottom:10px;">
        </div>

        <div>
            <label>Bought Price</label><br>
            <input type="number" step="0.01" name="bought_price" value="{{ $product->bought_price }}" required style="width:100%; padding:8px; margin-bottom:10px;">
        </div>

        <div>
            <label>Sale Price</label><br>
            <input type="number" step="0.01" name="sale_price" value="{{ $product->sale_price }}" required style="width:100%; padding:8px; margin-bottom:10px;">
        </div>

        <div>
            <label>Quantity</label><br>
            <input type="number" name="quantity" value="{{ $product->quantity }}" required style="width:100%; padding:8px; margin-bottom:10px;">
        </div>

        <div>
            <label>Category</label><br>
            <select name="category_id" required style="width:100%; padding:8px; margin-bottom:10px;">
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="button">Update Product</button>
    </form>
</div>
@endsection
