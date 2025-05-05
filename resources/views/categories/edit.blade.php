@extends('layouts.app')

@section('content')

    <div class="form-container">
        <div class="form-wrapper">
            <h2>Edit Product</h2>
            <form action=" {{ route('categories.update', $category)}} " method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <p>Name</p>
                <input type="text" name="name" id="name" value="{{$category->name}}" required>
                <p>Image</p>
                @if($category->image)
                    <img src="{{ asset('storage/' . $category->image) }}" class="category-form-img">
                @endif
                <input type="file" name="image">
                <button type="submit" class="button">Update</button>
            </form>
        </div>
    </div>
@endsection