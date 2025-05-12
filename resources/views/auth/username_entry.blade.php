<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>
<body>
    <div class="auth-wrapper">
        <form class="login-wrapper" action="{{route('forget_password')}}" method="POST">
            @csrf

            <a href="/" class="logo">SHOP</a>
            <div class="login-form">
                <label for="username">Username</label>
                <input type="text" id="username" name="username">
            </div>
            <button type="submit">Check</button>
        </form>
        <div class="auth-links">
            <a href="{{route('login')}}">back to login</a>
        </div>
    </div>
</body>
</html>