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
        <form class="login-wrapper" method="POST" action="{{route('validate_answer')}}">
            @csrf
            <a href="/" class="logo">SHOP</a>
            <p class="question">{{$user->security_question}}</p>
            <div class="login-form">
                <label for="answer">Answer</label>
                <input type="text" name="answer" id="answer" required>
                <input type="hidden" name="username" value="{{$user->username}}">
            </div>
            <button type="submit">Validate</button>
        </form>
        <div class="auth-links">
            <a href="{{route('login')}}">Back to login</a>
        </div>
    </div>
</body>
</html>