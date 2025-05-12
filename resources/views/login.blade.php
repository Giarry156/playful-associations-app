<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet"/>

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.scss', 'resources/css/navbar.scss', 'resources/css/form.scss', 'resources/js/app.js'])
    @endif
</head>
<body>
    <nav>
        <div class="container">
            <h1>Hubsociazioni</h1>
        </div>
    </nav>
    <main>
        <div class="container">
            <x-login-form/>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const loginForm = document.getElementById('login-form');
            const emailField = document.querySelector('input[name="email"]');
            const passwordField = document.querySelector('input[name="password"]');

            loginForm.addEventListener('submit', function (event) {
                try {
                    event.preventDefault();

                    const email = emailField.value;
                    const password = passwordField.value;

                    if (!email || !password) {
                        alert('Please fill in all fields.');
                        return;
                    }

                    loginForm.submit();
                } catch (e) {
                    console.log(e);
                }
            });
        });
    </script>
</body>
</html>
