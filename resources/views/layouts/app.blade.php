<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <?php echo app('Tightenco\Ziggy\BladeRouteGenerator')->generate(); ?>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        @if(Auth::check() && Auth::user()->account_type  == "admin")
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('sections') ? 'active' : '' }}" href="{{ route('sections') }}">{{ __('Sections') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('students') ? 'active' : '' }}" href="{{ route('students') }}">{{ __('Students') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('guardians') ? 'active' : '' }}" href="{{ route('guardians') }}">{{ __('Guardians') }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteNamed('teachers') ? 'active' : '' }}" href="{{ route('teachers') }}">{{ __('Teachers') }}</a>
                        </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link {{ Route::currentRouteNamed('home') ? 'active' : '' }}" href="{{ route('home') }}">{{ __('Home') }}</a>
                            </li>
                        @endif
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->username }}
                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" data-bs-toggle="modal" data-bs-target="#changePasswordModal" href="#">
                                        Change Password
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>


                    <change-password-modal />
                </div>
            </div>
        </nav>

        <main class="py-4">
            <div class="container-fluid">
                @yield('content')
            </div>
        </main>
    </div>
</body>
</html>
