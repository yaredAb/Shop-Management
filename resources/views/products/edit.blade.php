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
                 
                @if (App\Models\Setting::getValue('does_country') == true)
                    <p>Country:</p>
                    <input type="text" name="country" value="{{$product->country}}" class=" rounded-sm @error('country') border-1 border-red-500 @enderror">
                @endif
                
                <p>Bought Price:</p>
                <input type="number" step="0.01" name="bought_price" value="{{ $product->bought_price }}" required>
                <p>Sale Price:</p>
                <input type="number" step="0.01" name="sale_price" value="{{$product->sale_price}}" required>
                <p>Quantity:</p>
                <input type="number" name="quantity" value="{{$product->quantity}}" required>
                <p>Stock Threshold:</p>
                <input type="number" name="stock_threshold" value="{{$product->stock_threshold}}" required>
                <p>Category:</p>
                <select name="category_id">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @if (App\Models\Setting::getValue('does_expiry') == true)
                    <p>
                    <label>
                        <input type="checkbox" name="has_expiry" id="has_expiry" {{$product->expiry_date ? 'checked' : ''}}>
                        Has Expiry Date?
                    </label>
                    </p>
                    <div id="expiry_date_wrapper" style="display: none;">
                        <p>Expiry Date:</p>
                        <input type="date" name="expiry_date" id="expiry_date" value="{{ $product->expiry_date }}">
                    </div>
                @endif
                
                <button type="submit">Save</button>
            </form>
        </div>
    </div>
@endsection
@section('script')
    <script>
        document.getElementById('has_expiry').addEventListener('change', function () {
            const wrapper = document.getElementById('expiry_date_wrapper');
            wrapper.style.display = this.checked ? 'block' : 'none';
        })
    </script>
@endsection
