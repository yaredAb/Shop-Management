@extends('layouts.clean')

@section('childContent')
    <div class="auth-wrapper">
        <form class="login-wrapper" action="{{route('register.submit')}}" method="POST">
            @csrf

            <a href="/" class="logo">{{$site_title}}</a>
            @if ($errors->any())
                <div class="bg-red-200 p-2">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-red-700 py-1 text-lg text-center">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="login-form">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" class="border border-gray-400" value="{{old('username')}}">
            </div>
            <div class="login-form">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="border border-gray-400">
            </div>
            <div class="login-form">
                <label for="password">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password" class="border border-gray-400">
            </div>
            <div class="login-form">
                <label for="password">Privilage</label>
                <select name="privilage" class="px-5 py-2 border border-gray-400">
                    <option value="">--select privilage--</option>
                    <option value="user">User</option>
                    <option value="admin">Adminstrator</option>
                </select>
            </div>
            <button type="submit">Register</button>
        </form>
        <div class="auth-links">
            <a href="{{route('login')}}">sign in</a>
        </div>
    </div>
@endsection
