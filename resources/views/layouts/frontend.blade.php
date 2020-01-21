<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>

    <meta name="description" content="">
    <meta name="author" content="3things">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="{{ config('app.name') }}">
    <meta property="og:site_name" content="{{ config('app.name') }}">
    <meta property="og:description" content="">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <link rel="stylesheet" id="css-main" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
</head>
<body>
<div id="page-container" class="main-content-boxed page-header-fixed page-header-glass">
    <header id="page-header">
        <div class="content-header">
            <div class="d-flex align-items-center">
                <a href="{{ route('frontend.index') }}" class="font-w700">
                    {{ config('app.name') }}
                </a>
            </div>

            <div class="d-flex align-items-center">
                <li class="nav-main-item">
                    <a href="{{ route('auth.login') }}" class="nav-main-link">
                        <span class="nav-main-link-name">Login</span>
                    </a>
                </li>

                <li class="nav-main-item">
                    <a href="{{ route('auth.register') }}" class="nav-main-link">
                        <span class="nav-main-link-name">Create Account</span>
                    </a>
                </li>
            </div>
        </div>
    </header>

    <!-- Main Container -->
    <main id="main-container">
        <div class="content content-boxed">
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
