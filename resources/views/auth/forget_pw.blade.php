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
        <form class="login-wrapper">
            <a href="/" class="logo">SHOP</a>
            <p>What is your favorite food?</p>
            <div class="login-form">
                <label for="answer">Answer</label>
                <input type="text" name="answer" id="answer">
            </div>
            <button type="submit">Validate</button>
        </form>
        <div class="auth-links">
            <a href="{{route('login')}}">Back to login</a>
        </div>
    </div>
</body>
</html>