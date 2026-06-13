<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
                    colors: {
                        brand: '#63CFC0',
                        brandHover: '#7ae0d3',
                        background: '#050505',
                        surface: '#0b0b0b',
                        surfaceHover: '#151515',
                        surfaceElevated: '#111111',
                        surfaceActive: '#1a1a1a',
                        border: '#222222'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-background text-white font-sans">
    <!-- <nav class="bg-blue-600 text-white p-4">
        <div class="container mx-auto flex justify-between">
            <h1 class="text-xl font-bold">ReTide Admin</h1>
            <div>
                <a href="{{ route('home') }}" class="mr-4">Home</a>
                <a href="{{ route('logout') }}">Logout</a>
            </div>
        </div>
    </nav> -->

    <div class="container mx-auto p-4">
        @yield('content')
    </div>
    @yield('scripts')
</body>
</html>