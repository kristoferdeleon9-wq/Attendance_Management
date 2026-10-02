<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Login - AttendEase</title>

    @vite('resources/css/login.css')

</head>

<body>

<div class="login-page">

    <div class="login-card">

        {{-- LOGO --}}

        <div class="login-logo">
            A
        </div>

        <h1>
            Welcome to AttendEase
        </h1>

        <p class="login-subtitle">
            Attendance Management System
        </p>


        {{-- SUCCESS MESSAGE --}}

        @if(session('success'))

            <div class="alert success">
                ✓ {{ session('success') }}
            </div>

        @endif


        {{-- ERRORS --}}

        @if($errors->any())

            <div class="alert error">

                {{ $errors->first() }}

            </div>

        @endif


        {{-- LOGIN FORM --}}

        <form
            action="{{ route('login') }}"
            method="POST"
            id="loginForm"
        >

            @csrf


            {{-- EMAIL --}}

            <div class="form-group">

                <label for="email">
                    Email Address
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder="Enter your email"
                    required
                    autofocus
                >

            </div>


            {{-- PASSWORD --}}

            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Enter your password"
                    required
                >

            </div>


            {{-- REMEMBER --}}

            <div class="remember-row">

                <label>

                    <input
                        type="checkbox"
                        name="remember"
                    >

                    Remember me

                </label>

            </div>


            {{-- BUTTON --}}

            <button
                type="submit"
                class="login-button"
            >
                Login
            </button>

        </form>

    </div>

</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', async function (e) {

        if (!window.NativePHP) {
            return;
        }

        e.preventDefault();

        const email = document.getElementById('email').value;
        const password = document.getElementById('password').value;

        try {
            const response = await fetch(
                'https://amenities-government-ancient-similarly.trycloudflare.com/api/login',
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        email: email,
                        password: password
                    })
                }
            );

            const data = await response.json();

            if (response.ok) {
                localStorage.setItem('auth_token', data.token);
                window.location.href = '/dashboard';
            } else {
                alert(data.message);
            }

        } catch (error) {
            alert('Unable to connect to AttendEase server.');
        }
    });
</script>

</body>

</html>