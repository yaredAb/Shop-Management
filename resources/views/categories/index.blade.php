@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>All Categories</h2>
        <a href="{{ route('categories.create') }}" class="button">Add New Category</a>

        @if(session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div>
            @foreach ($categories as $category)
                <div class="category-card">
                    @if ($category->image)
                        <img src="{{asset('storage/'. $category->image)}}" alt="{{$category->name}}">
                    @endif
                    <h3>{{ $category->name }}</h3>
                    <div>
                        <a href="{{route('categories.edit', $category)}}" class="button"> Edit </a>

                        <form action=" {{route('categories.destroy', $category)}} " method="POST" onsubmit="return('Are you sure you want to delete this category?')">
                            @csrf
                            @method('DELETE')
                            <button class="button">Delete</button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection