@extends('layouts.app')

@section('content')
    <h3>edit categories</h3>

    <form action=" {{ route('categories.update', $category)}} " method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" value="{{$category->name}}" required>
        </div>
        <div>
            <label>Image</label><br>
            <input type="file" name="image" style="margin-bottom:10px;">
        </div>

        @if($category->image)
            <img src="{{ asset('storage/' . $category->image) }}" style="width: 200px; height: auto; margin-top: 10px;">
        @endif

        <div style="margin-top: 10px;">
            <button type="submit" class="button">Update</button>
        </div>
    </form>
@endsection