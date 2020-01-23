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
<div id="page-container" class="sidebar-inverse side-scroll main-content-boxed side-trans-enabled page-header-dark">
    <header id="page-header">
        <div class="content-header">
            <div>
                <a class="link-fx font-size-lg text-dual" href="{{ route('home') }}">
                    <span class="font-w700 text-dual">
                        {{ config('app.name') }}
                    </span>
                </a>
            </div>

            <div>
                <div class="dropdown d-inline-block">
                    <button type="button" class="btn btn-dual" id="page-header-user-dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="img-avatar img-avatar32 img-avatar-thumb" src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
                        <i class="fa fa-fw fa-angle-down ml-1"></i>
                    </button>

                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-lg p-0" aria-labelledby="page-header-user-dropdown">
                        <div class="rounded-top font-w600 text-center p-3 border-bottom">
                            <img class="img-avatar img-avatar48" src="{{ Auth::user()->avatar }}" alt="{{ Auth::user()->name }}">
                            <div class="pt-2"></div>
                            <a class="font-w600 text-dark" href="javascript:void(0)">{{ Auth::user()->name }}</a>
                            <div class="font-size-sm text-muted">{{ Auth::user()->email }}</div>
                        </div>

                        <div class="p-2">
                            <a class="dropdown-item" href="{{ route('account') }}">
                                <i class="fa fa-fw fa-cog text-gray mr-1"></i> Settings
                            </a>

                            <a class="dropdown-item mb-0" href="#" onclick="document.getElementById('logout-form').submit();">
                                <i class="fa fa-fw fa-arrow-circle-left text-gray mr-1"></i> Sign Out
                            </a>
                        </div>

                        <form action="{{ route('auth.logout') }}" method="post" style="display: none;" id="logout-form">
                            @csrf
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <main id="main-container">
        <div class="bg-white border-bottom">
            <div class="content py-0">
                <ul class="nav nav-tabs nav-tabs-alt border-bottom-0 justify-content-center justify-content-md-start">
                    <li class="nav-item">
                        <a class="nav-link text-body-color py-4 {{ Route::is('home') ? 'active' : '' }}" href="{{ route('home') }}">
                            <i class="fa fa-rocket fa-fw text-gray"></i> <span class="d-none d-md-inline ml-1">
                                Home
                            </span>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link text-body-color py-4 {{ Route::is('alias.create') ? 'active' : '' }}" href="{{ route('alias.create') }}">
                            <i class="fa fa-envelope-open fa-fw text-gray"></i> <span class="d-none d-md-inline ml-1">
                                Create Alias
                            </span>
                        </a>
                    </li>

                    <li class="nav-item pull-right">
                        <a class="nav-link text-body-color py-4 {{ Route::is('billing') ? 'active' : '' }}" href="{{ route('billing') }}">
                            <i class="fa fa-credit-card fa-fw text-gray"></i> <span class="d-none d-md-inline ml-1">
                                Billing
                            </span>
                        </a>
                    </li>

                    <li class="nav-item pull-right">
                        <a class="nav-link text-body-color py-4 {{ Route::is('account') ? 'active' : '' }}" href="{{ route('account') }}">
                            <i class="fa fa-cog fa-fw text-gray"></i> <span class="d-none d-md-inline ml-1">
                                Settings
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="content">
            @yield('content')
        </div>
    </main>

    <footer id="page-footer" class="bg-white border-top">
        <div class="content py-0">
            <div class="row font-size-sm">
                <div class="col-sm-6 order-sm-2 mb-1 mb-sm-0 text-center text-sm-right">
                    Crafted with <i class="fa fa-heart text-danger"></i> by 3things
                </div>

                <div class="col-sm-6 order-sm-1 text-center text-sm-left">
                    {{ config('app.name') }}
                </div>
            </div>
        </div>
    </footer>
</div>

<script src="{{ mix('js/app.js') }}"></script>
</body>
</html>

