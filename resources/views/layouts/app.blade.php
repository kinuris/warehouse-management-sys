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
    <!-- <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet"> -->
    <link rel="shortcut icon" href="{{ asset('assets/favicon.ico') }}" type="image/x-icon">

    <!-- Scripts -->
    @vite(['resources/js/app.js', 'resources/css/app.css'])
</head>

<body>
    @if (session('message'))
    <div class="relative">
        <div id="flash-message" class="bg-green-300 w-full p-2 z-50">
            {{ session('message') }}
            <div id="progress-bar" class="h-1 bg-green-500 absolute bottom-0 left-0 w-full"></div>
        </div>
    </div>
    <script>
        const duration = 3000;
        const progressBar = document.getElementById('progress-bar');
        const flashMessage = document.getElementById('flash-message');

        let start = null;

        function animate(timestamp) {
            if (!start) start = timestamp;
            const progress = timestamp - start;
            const width = 100 - ((progress / duration) * 100);

            if (width <= 0) {
                flashMessage.style.display = 'none';
                return;
            }

            progressBar.style.width = width + '%';
            requestAnimationFrame(animate);
        }

        requestAnimationFrame(animate);
    </script>
    @endif

    <div id="app" class="flex">
        <nav class="flex bg-gray-800 h-screen md:min-w-72 shadow-lg absolute md:relative z-50" id="sidebar">
            <div class="p-6 w-full">
                <div class="flex items-center justify-between mb-8">
                    <a class="flex items-center" href="{{ url('/') }}">
                        <img class="h-10 w-10 mr-3 rounded-lg" src="{{ asset('assets/logo.jpg') }}" alt="Logo">
                        <span class="text-xl font-semibold text-white">Sobida WMS</span>
                    </a>
                    <button id="sidebarToggle" class="text-white md:hidden ml-4">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>

                <ul class="space-y-2">
                    @php($user = auth()->user())
                    @if($user && $user->isSysRole('employee'))
                    <li>
                        <a href="{{ route('deliveries') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-truck mr-3"></i>
                            <span>Pending Deliveries</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('deliveries_success') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-check-circle mr-3"></i>
                            <span>Successful Deliveries</span>
                        </a>
                    </li>
                    @elseif($user && $user->isSysRole('manager'))
                    <li>
                        <a href="{{ route('incoming') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-box-arrow-in-down mr-3"></i>
                            <span>Incoming Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('orders') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-cart mr-3"></i>
                            <span>Sales Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('distributor') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-people mr-3"></i>
                            <span>Distributors</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inventory') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-box mr-3"></i>
                            <span>Inventory Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-person-gear mr-3"></i>
                            <span>User Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.index') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-people-fill mr-3"></i>
                            <span>Customers</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-file-earmark-text mr-3"></i>
                            <span>Summary and Reports</span>
                        </a>
                    </li>
                    @elseif ($user && $user->isSysRole('admin'))
                    <li>
                        <a href="{{ route('orders') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-cart mr-3"></i>
                            <span>Sales Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('distributor') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-people mr-3"></i>
                            <span>Distributors</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('inventory') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-box mr-3"></i>
                            <span>Inventory Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('users') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-person-gear mr-3"></i>
                            <span>User Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('reports') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-file-earmark-text mr-3"></i>
                            <span>Report Generation</span>
                        </a>
                    </li>
                    @endif

                    @guest
                    @if (Route::has('login'))
                    <li>
                        <a href="{{ route('login') }}" class="flex items-center px-4 py-3 text-gray-300 rounded-lg hover:bg-gray-700 hover:text-white transition-all">
                            <i class="bi bi-box-arrow-in-right mr-3"></i>
                            <span>{{ __('Login') }}</span>
                        </a>
                    </li>
                    @endif
                    @else
                    <li class="mt-auto pt-4 border-t border-gray-700">
                        <div class="px-4 py-3">
                            <a href="{{ route('logout') }}"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                class="flex items-center px-4 py-2 text-red-400 rounded-lg hover:bg-red-500 hover:text-white transition-all">
                                <i class="bi bi-box-arrow-right mr-3"></i>
                                <span>{{ __('Logout') }}</span>
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endguest

                </ul>
            </div>
        </nav>
        <button id="mobileMenuBtn" class="fixed top-4 left-4 z-40 md:hidden text-white bg-gray-800 p-2 rounded-lg">
            <i class="bi bi-list text-xl"></i>
        </button>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const sidebar = document.getElementById('sidebar');
                const mobileMenuBtn = document.getElementById('mobileMenuBtn');
                const sidebarToggle = document.getElementById('sidebarToggle');

                // Initially hide sidebar on mobile
                if (window.innerWidth < 768) {
                    sidebar.style.transform = 'translateX(-100%)';
                }

                function toggleSidebar() {
                    const isHidden = sidebar.style.transform === 'translateX(-100%)';
                    sidebar.style.transition = 'transform 0.3s ease-in-out';
                    sidebar.style.transform = isHidden ? 'translateX(0)' : 'translateX(-100%)';
                }

                mobileMenuBtn.addEventListener('click', toggleSidebar);
                sidebarToggle.addEventListener('click', toggleSidebar);

                // Handle window resize
                window.addEventListener('resize', function() {
                    if (window.innerWidth >= 768) {
                        sidebar.style.transform = 'translateX(0)';
                    } else {
                        sidebar.style.transform = 'translateX(-100%)';
                    }
                });
            });
        </script>

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