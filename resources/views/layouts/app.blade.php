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

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/favicon.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body>
    @if (session('message'))
    <div class="bg-green-300 w-full p-2 z-50">{{ session('message') }}</div>
    @endif

    <div id="app" class="flex">
        <nav class="flex bg-gray-400 h-screen min-w-64">
            <div class="p-5 w-full">
                <a class="flex mb-3" href="{{ url('/') }}">
                    <img class="me-2" style="width: 32px;" src="{{ asset('assets/logo.jpg') }}" alt="Logo">
                    <p class="text-lg">Sobida WMS</p>
                </a>
                <ul class="flex flex-col gap-3">
                    @php($user = auth()->user())
                    @if($user && $user->isSysRole('employee'))
                    <li class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full">
                        <a href="{{ route('deliveries') }}" class="nav-link">Pending Deliveries</a>
                    </li>

                    <li class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full">
                        <a href="{{ route('deliveries_success') }}" class="nav-link">Successful Deliveries</a>
                    </li>
                    @elseif($user && $user->isSysRole('manager'))
                    <li class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full">
                        <a href="{{ route('incoming') }}" class="nav-link">Incoming Orders</a>
                    </li>

                    <li class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full">
                        <a href="{{ route('orders') }}" class="nav-link">Sales Management</a>
                    </li>

                    <!-- <li class="nav-item">
                            <a href="{{ route('employee_attendance') }}" class="nav-link">Employee Attendance Tracking</a>
                        </li> -->
                    <li class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full">
                        <a href="{{ route('distributor') }}" class="nav-link">Distributors</a>
                    </li>

                    <li class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full">
                        <a href="{{ route('inventory') }}" class="nav-link">Inventory Management</a>
                    </li>

                    <li class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full">
                        <a href="{{ route('users') }}" class="nav-link">User Management</a>
                    </li>

                    <li class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full">
                        <a href="{{ route('reports') }}" class="nav-link">Summary and Reports</a>
                    </li>
                    @elseif ($user && $user->isSysRole('admin'))
                    <!-- <li class="nav-item">
                            <a href="{{ route('incoming') }}" class="nav-link">Incoming Orders</a>
                        </li> -->

                    <li class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full">
                        <a href="{{ route('orders') }}" class="nav-link">Sales Management</a>
                    </li>

                    <li class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full">
                        <a href="{{ route('distributor') }}" class="nav-link">Distributors</a>
                    </li>

                    <li class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full">
                        <a href="{{ route('inventory') }}" class="nav-link">Inventory Management</a>
                    </li>

                    <li class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full">
                        <a href="{{ route('users') }}" class="nav-link">User Management</a>
                    </li>

                    <!-- <li class="nav-item">
                            <a href="{{ route('warehouse') }}" class="nav-link">Warehouse Management</a>
                        </li> -->

                    <li class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full">
                        <a href="{{ route('reports') }}" class="nav-link">Report Generation</a>
                    </li>
                    @endif

                    @guest
                    @if (Route::has('login'))
                    <li class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                    @endif
                    @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="flex flex-col gap-3">
                            <a class="block py-2.5 px-4 rounded transition duration-200 bg-gray-700 hover:bg-white hover:text-grey-700 text-gray-300 mt-1 w-full" href="{{ route('logout') }}" onclick="event.preventDefault();
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
        </nav>

        <main class="h-screen w-full p-5 overflow-y-auto">
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