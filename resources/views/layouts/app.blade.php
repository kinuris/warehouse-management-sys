<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="{{ asset('assets/css/filepond.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/choices.min.css') }}">
    <link rel="stylesheet" href=" https://printjs-4de6.kxcdn.com/print.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/favicon.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img class="me-2" style="width: 32px;" src="{{ asset('assets/logo.jpg') }}" alt="Logo">
                    Sobida WMS
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->

                        @php($user = auth()->user())
                        @if($user && $user->isSysRole('employee'))
                        <li class="nav-item">
                            <a href="{{ route('deliveries') }}" class="nav-link">Pending Deliveries</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('deliveries_success') }}" class="nav-link">Successful Deliveries</a>
                        </li>
                        @elseif($user && $user->isSysRole('manager'))
                        <!-- <li class="nav-item">
                            <a href="{{ route('incoming') }}" class="nav-link">Incoming Orders</a>
                        </li> -->

                        <li class="nav-item">
                            <a href="{{ route('orders') }}" class="nav-link">Sales Management</a>
                        </li>

                        <!-- <li class="nav-item">
                            <a href="{{ route('employee_attendance') }}" class="nav-link">Employee Attendance Tracking</a>
                        </li> -->

                        <li class="nav-item">
                            <a href="{{ route('inventory') }}" class="nav-link">Inventory Management</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('users') }}" class="nav-link">User Management</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('reports') }}" class="nav-link">Report Generation</a>
                        </li>
                        @elseif ($user && $user->isSysRole('admin'))
                        <!-- <li class="nav-item">
                            <a href="{{ route('incoming') }}" class="nav-link">Incoming Orders</a>
                        </li> -->

                        <li class="nav-item">
                            <a href="{{ route('orders') }}" class="nav-link">Sales Management</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('inventory') }}" class="nav-link">Inventory Management</a>
                        </li>

                        <li class="nav-item">
                            <a href="{{ route('users') }}" class="nav-link">User Management</a>
                        </li>

                        <!-- <li class="nav-item">
                            <a href="{{ route('warehouse') }}" class="nav-link">Warehouse Management</a>
                        </li> -->

                        <li class="nav-item">
                            <a href="{{ route('reports') }}" class="nav-link">Report Generation</a>
                        </li>
                        @endif

                        @guest
                        @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                                @if(($user && $user->isSysRole('manager')) || ($user && $user->isSysRole('admin')))
                                <a class="dropdown-item" href="{{ route('users') }}">
                                    {{ __('User Management') }}
                                </a>
                                @endif

                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
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
                </div>
            </div>
        </nav>

        @if (session('message'))
        <div class="alert alert-info">{{ session('message') }}</div>
        @endif

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script src="https://printjs-4de6.kxcdn.com/print.min.js"></script>
    <script src="{{ asset('assets/js/filepond.js') }}"></script>
    <script src="{{ asset('assets/js/choices.min.js') }}"></script>
    <script src="{{ asset('assets/js/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('assets/js/charts.min.js') }}"></script>
    @yield('script')
</body>

</html>