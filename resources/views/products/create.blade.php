@extends('layouts.app')

@section('content')
        <div class="form-container">
            <div class="form-wrapper">
                <h2>Create Product</h2>
                <form action="{{route('products.store')}}" method="POST">
                    @csrf
                    <p>Name:</p>
                    <input type="text" name="name">
                    <p>Bought Price:</p>
                    <input type="number" step="0.01" name="bought_price">
                    <p>Sale Price:</p>
                    <input type="number" step="0.01" name="sale_price">
                    <p>Quantity:</p>
                    <input type="number" name="quantity">
                    <p>Category:</p>
                    <select name="category_id">
                        <option value="">--select category--</option>
                        @foreach ($categories as $category)
                            <option value="{{$category->id}}">{{$category->name}}</option>
                        @endforeach
                    </select>
                    <button type="submit">Save</button>
                </form>
            </div>
        </div>
@endsection