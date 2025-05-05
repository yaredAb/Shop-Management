@extends('layouts.app')

@section('content')
    <div class="form-container">
        <div class="form-wrapper">
            <h2>create category</h2>
            <form action="{{route('categories.store')}}" method="POST" enctype="multipart/form-data">
                @csrf
                <p>Name:</p>
                <input type="text" name="name">
                <p>Image:</p>
                <input type="file" name="image">
                <button type="submit" class="button">Save</button>
            </form>
        </div>
    </div>
@endsection