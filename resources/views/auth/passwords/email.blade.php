    @extends('layouts.clean')

    @section('childContent')
        <div class="auth-wrapper">
            <form class="login-wrapper" action="{{route('password.email')}}" method="POST">
                @csrf

                <a href="/" class="logo">{{$site_title}}</a>
                <p class="font-medium text-lg">Forget Password</p>
                @if ($errors->any())
                    <div class="bg-red-200 p-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li class="text-red-700 py-1 text-lg text-center">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('status'))
                    <div class="p-2 bg-green-300">
                        <p class="text-lg py-1 text-center text-green-700">{{session('status')}}</p>
                    </div>
                @endif
                <div class="login-form">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" value="{{old('email')}}" class="border border-gray-400">
                </div>
                <button type="submit">Send Validation Link</button>
            </form>
            <div class="auth-links">
                <a href="{{route('login')}}">Back to login</a>
            </div>
        </div>
    @endsection
