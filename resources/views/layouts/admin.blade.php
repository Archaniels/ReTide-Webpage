<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Dashboard - {{ config('app.name', 'ReTide') }}</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#63cfc0',
                        dark: '#000000',
                        'dark-lighter': '#121212',
                        'dark-card': '#1e1e1e',
                        secondary: '#c7c7c7',
                    },
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        /* Custom Scrollbar for dark theme */
        ::-webkit-scrollbar {
            width: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #000000;
        }
        ::-webkit-scrollbar-thumb {
            background: #333;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #63cfc0;
        }
    </style>
</head>
<body class="bg-dark text-white flex min-h-screen">

    <!-- Sidebar -->
    <aside class="w-64 bg-dark-lighter border-r border-gray-800 flex flex-col fixed inset-y-0 left-0 z-50 transition-transform duration-300 transform md:translate-x-0 -translate-x-full" id="sidebar">
        <div class="flex items-center justify-center h-20 border-b border-gray-800">
            <h1 class="text-2xl font-bold uppercase tracking-wider text-primary">ReTide Admin</h1>
        </div>
        <nav class="flex-grow px-4 py-6 space-y-2 overflow-y-auto">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-primary text-black' : 'text-secondary hover:bg-gray-800 hover:text-primary' }}">
                <i class="fas fa-tachometer-alt w-6"></i> <span>Dashboard</span>
            </a>
            <a href="{{ route('admin.accounts.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.accounts.*') ? 'bg-primary text-black' : 'text-secondary hover:bg-gray-800 hover:text-primary' }}">
                <i class="fas fa-users w-6"></i> <span>Users</span>
            </a>
            <a href="{{ route('admin.marketplace.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.marketplace.*') ? 'bg-primary text-black' : 'text-secondary hover:bg-gray-800 hover:text-primary' }}">
                <i class="fas fa-store w-6"></i> <span>Marketplace</span>
            </a>
            <a href="{{ route('admin.blogs.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.blogs.*') ? 'bg-primary text-black' : 'text-secondary hover:bg-gray-800 hover:text-primary' }}">
                <i class="fas fa-blog w-6"></i> <span>Blog</span>
            </a>
            <a href="{{ route('admin.donations.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.donations.*') ? 'bg-primary text-black' : 'text-secondary hover:bg-gray-800 hover:text-primary' }}">
                <i class="fas fa-hand-holding-heart w-6"></i> <span>Donations</span>
            </a>
            <a href="{{ route('admin.payments.index') }}" class="flex items-center px-4 py-3 rounded-xl transition-all duration-200 {{ request()->routeIs('admin.payments.*') ? 'bg-primary text-black' : 'text-secondary hover:bg-gray-800 hover:text-primary' }}">
                <i class="fas fa-credit-card w-6"></i> <span>Payments</span>
            </a>
        </nav>
        <div class="p-4 border-t border-gray-800">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="flex items-center w-full px-4 py-3 text-red-400 hover:bg-red-500/10 hover:text-red-500 rounded-xl transition-all duration-200">
                    <i class="fas fa-sign-out-alt w-6"></i> <span>Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col md:ml-64">
        <!-- Top Header -->
        <header class="bg-dark-lighter/80 backdrop-blur-md border-b border-gray-800 h-20 flex items-center justify-between px-6 sticky top-0 z-40">
            <div class="flex items-center">
                <button id="mobile-sidebar-toggle" class="mr-4 text-secondary hover:text-primary md:hidden">
                    <i class="fas fa-bars text-xl"></i>
                </button>
                <h2 class="text-xl font-bold text-white tracking-tight">@yield('header', 'Dashboard')</h2>
            </div>
            <div class="flex items-center space-x-4">
                <div class="hidden md:flex flex-col items-end mr-2">
                    <span class="text-sm font-semibold text-white">{{ auth()->user()->name }}</span>
                    <span class="text-xs text-secondary">Administrator</span>
                </div>
                <div class="w-10 h-10 rounded-full bg-primary flex items-center justify-center text-black font-bold text-lg">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            </div>
        </header>

        <!-- Page Content -->
        <main class="p-6 md:p-8 flex-grow">
            @if(session('success'))
                <div class="mb-6 flex items-center p-4 rounded-xl bg-green-500/10 border border-green-500/20 text-green-400" role="alert">
                    <i class="fas fa-check-circle mr-3"></i>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-6 flex items-center p-4 rounded-xl bg-red-500/10 border border-red-500/20 text-red-400" role="alert">
                    <i class="fas fa-exclamation-circle mr-3"></i>
                    <span class="font-medium">{{ session('error') }}</span>
                </div>
            @endif

            @yield('content')
        </main>
        
        <!-- Footer -->
        <footer class="p-6 border-t border-gray-800 text-center text-secondary text-sm">
            &copy; {{ date('Y') }} ReTide. All rights reserved.
        </footer>
    </div>

    <script>
        // Simple mobile sidebar toggle
        const toggle = document.getElementById('mobile-sidebar-toggle');
        const sidebar = document.getElementById('sidebar');
        
        if (toggle) {
            toggle.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }
    </script>
</body>
</html>
