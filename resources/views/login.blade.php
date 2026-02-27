<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    @vite(['resources/css/app.css'])
</head>
<body class="auth-body">

<div class="auth-wrapper">
    <form method="POST" action="{{ route('login.submit') }}" class="auth-card">
        @csrf

        <h2 class="auth-title">Авторизация</h2>

        <input
            type="email"
            name="email"
            value="test@test.com"
            placeholder="Email"
            class="auth-input"
            required
        >

        <input
            type="password"
            name="password"
            value="test"
            placeholder="Password"
            class="auth-input"
            required
        >

        <button type="submit" class="auth-button">
            Войти
        </button>

        @if ($errors->any())
            <div class="auth-error">
                {{ $errors->first() }}
            </div>
        @endif
    </form>
</div>

</body>
</html>