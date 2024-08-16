<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel E-commerce</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Styles -->
    <style>
        body {
            margin: 0;
            font-family: Figtree, ui-sans-serif, system-ui, sans-serif, Apple Color Emoji, Segoe UI Emoji, Segoe UI Symbol, Noto Color Emoji;
        }

        .navbar {
            background-color: #2d3748;
            color: #fff;
            padding: 1rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar a {
            color: inherit;
            text-decoration: none;
            margin: 0 0.5rem;
            transition: color 0.2s;
        }

        .navbar a:hover {
            color: #cbd5e0;
        }

        .main-section {
            position: relative;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
        }

        .main-section h1 {
            margin-bottom: 1rem;
            font-size: 2.5rem;
        }

        .main-section p {
            margin-bottom: 2rem;
            font-size: 1.25rem;
        }

        .main-section img {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: -1;
            opacity: 0.5;
        }

        .footer {
            background-color: #2d3748;
            color: #fff;
            text-align: center;
            padding: 2rem 1rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
        }

        .footer .social-links a {
            margin: 0 0.5rem;
            color: #fff;
            text-decoration: none;
            font-size: 1.25rem;
            transition: color 0.2s;
        }

        .footer .social-links a:hover {
            color: #cbd5e0;
        }

        @media (max-width: 768px) {
            .main-section h1 {
                font-size: 2rem;
            }

            .main-section p {
                font-size: 1rem;
            }
        }
    </style>
</head>

<body>
    <div class="navbar">
        <a href="#" class="text-xl font-semibold">E-commerce</a>
        <nav class="flex items-center">
            @if (Route::has('login'))
            @auth
            <a href="{{ url('/dashboard') }}" class="p-4">Dashboard</a>
            @else
            <a href="{{ route('login') }}" class="p-4">Log in</a>
            @if (Route::has('register'))
            <a href="{{ route('register') }}" class="p-4 ml-4">Register</a>
            @endif
            @endauth
            @endif
        </nav>
    </div>

    <div class="main-section">
        <img src="https://aimeos.org/fileadmin/aimeos.org/images/aimeos-screen-laravel-ecommerce.png" alt="E-commerce Banner">
        <div>
            <h1>Welcome to Our E-commerce Site</h1>
            <p>Your one-stop shop for all your needs.</p>
        </div>
    </div>

    <footer class="footer">
        <div>
            <p>Contact us at: "YURESHA", Ihala Boowalla , Rikillagaskada</p>
            <p>Email: is.senanayaka.m@gmail.com | Phone: +94766277163</p>
        </div>
        <div class="social-links">
            <a href="https://facebook.com" target="_blank">Facebook</a>
            <a href="https://twitter.com" target="_blank">Twitter</a>
            <a href="https://instagram.com" target="_blank">Instagram</a>
        </div>
        <div>
            <p>©2024 @ Created by Ishan Senanayaka</p>
        </div>
    </footer>
</body>

</html>