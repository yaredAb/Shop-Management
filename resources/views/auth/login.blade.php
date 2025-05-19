    @extends('layouts.clean')

    @section('childContent')
        <div class="auth-wrapper">
            <form class="login-wrapper" action="{{route('login')}}" method="POST">
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
                    <input type="text" id="username" name="username" value="{{old('username')}}" class="border border-gray-400">
                </div>
                <div class="login-form">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="border border-gray-400">
                </div>
                <button type="submit">Login</button>
            </form>
            <div class="auth-links">
                <a href="{{route('forget_password')}}">forget password</a>
            </div>
        </div>
    @endsection