<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard')</title>
    @vite('resources/css/app.css')
    <!-- <link href="{{ asset('css/app.css') }}" rel="stylesheet"> -->
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    <!-- Navbar -->
    <nav class="bg-gray-900 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <div>
                <a href="#" class="text-white text-lg font-semibold">Admin Panel</a>
            </div>
            <div>
                <form method="POST" action="{{ route('admin.logout') }}">
                    @csrf
                    <button type="submit" class="text-white hover:underline">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container">
        <div class="grid grid-cols-12 gap-4">
            <!-- Sidebar -->
            <aside class="col-span-2 h-[93vh] md:h-[90vh] overflow-auto bg-gray-800 p-4 rounded-lg text-white">
                <ul>
                    <li class="mb-2">
                        <a href="{{ route('admin.dashboard') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Dashboard</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.user') }}" class="block py-2 px-4 rounded hover:bg-gray-700">Manage Users</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.category')}}" class="block py-2 px-4 rounded hover:bg-gray-700">Category</a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.product')}}" class="block py-2 px-4 rounded hover:bg-gray-700">Product</a>
                    </li>
                </ul>
            </aside>

            <!-- Page Content -->
            <main class="col-span-10 h-[93vh] md:h-[90vh] overflow-auto bg-white p-6 rounded-lg shadow-lg">
                @yield('content')
            </main>
        </div>
    </div>
    <script src="{{ route('admin.scripts') }}"></script>

</body>
</html>
