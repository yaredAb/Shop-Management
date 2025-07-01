    @extends('layouts.clean')

    @section('childContent')
        <div class="auth-wrapper">
            <form class="login-wrapper" action="{{route('password.update')}}" method="POST">
                @csrf

                <a href="/" class="logo">{{$site_title}}</a>
                <p class="font-medium text-lg">Reset Password</p>
                @if ($errors->any())
                    <div class="bg-red-200 p-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-red-700 py-1 text-lg text-center">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="p-2 bg-green-300">
                        <p class="text-lg py-1 text-center text-green-700">{{session('status')}}</p>
                    </div>
                @endif
                <input type="hidden" name="token" value="{{ request()->route('token') }}">
                <input type="hidden" name="email" value="{{ request('email') }}">

                <div class="login-form">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="border border-gray-400">
                </div>
                <div class="login-form">
                    <label for="password_confirmation">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="border border-gray-400">
                </div>
                <button type="submit">Change Password</button>
            </form>
            <div class="auth-links">
                <a href="{{route('login')}}">Back to login</a>
            </div>
        </div>
    @endsection
