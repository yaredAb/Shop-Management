@extends('layouts.app')

@section('content')
        <div class="form-container">
            <div class="form-wrapper">
                <h2>Create Product</h2>
                <form action="{{route('products.store')}}" method="POST">
                    @csrf
                    <p>Name:</p>
                    <input type="text" name="name" value="{{old('name')}}" class=" rounded-sm @error('name') border-1 border-red-500 @enderror">
                    <p>Bought Price:</p>
                    <input type="number" step="0.01" name="bought_price" value="{{old('bought_price')}}" class=" rounded-sm @error('bought_price') border-1 border-red-500 @enderror">
                    <p>Sale Price:</p>
                    <input type="number" step="0.01" name="sale_price" value="{{old('sale_price')}}" class=" rounded-sm @error('sale_price') border-1 border-red-500 @enderror">
                    <p>Quantity:</p>
                    <input type="number" name="quantity" value="{{old('quantity')}}" class=" rounded-sm @error('quantity') border-1 border-red-500 @enderror">
                    <p>Stock Threshold:</p>
                    <input type="number" name="stock_threshold" value="{{old('stock_threshold')}}" class=" rounded-sm @error('stock_threshold') border-1 border-red-500 @enderror">
                    <p>Category:</p>
                    <select name="category_id" class=" rounded-sm @error('category_id') border-1 border-red-500 @enderror">
                        <option value="">--select category--</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    <p>
                        <label>
                            <input type="checkbox" name="has_expiry" id="has_expiry">
                            Has Expiry Date?
                        </label>
                    </p>
                    <div id="expiry_date_wrapper" style="display: none;">
                        <p>Expiry Date:</p>
                        <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}">
                    </div>
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
