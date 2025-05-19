@extends('layouts.app')

@section('content')
    <div class="cat-header">
        <h1>Users list</h1>
        <a href="{{route('register.form')}}">Add User</a>
    </div>
    <div class="table-wrapper">
        <table class="order-table">
            <thead>
            <tr>
                <th>No.</th>
                <th>Username</th>
                <th>Priviliage</th>
                <th>Registered at</th>
                <th>Action</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$user->username}}</td>
                    <td>{{$user->privilage}}</td>
                    <td>{{$user->created_at->format('F d, Y')}}</td>
                    <td>
                        <form action="{{route('users.delete', $user->id)}}" method="POST"
                              onsubmit="return(confirm('Are you sure you want to delete this user?'))">
                            @method('DELETE')
                            @csrf
                            <button class="deleteBtn">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endsection
