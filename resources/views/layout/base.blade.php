<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'My Website')</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <header>
    @include('layout.navbar')
    </header>

    <!-- Main Content -->
    <main id="MainContentOfBase" class=" h-[90vh] overflow-auto">
        @yield('content')
    </main>


    <!-- JavaScript files -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
