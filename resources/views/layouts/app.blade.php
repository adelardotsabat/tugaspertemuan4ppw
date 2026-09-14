<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Portfolio Saya')</title>
    {{-- Menggunakan @vite sesuai petunjuk tugas --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    {{-- Partial Navbar --}}
    @include('partials.navbar')

    {{-- Main Content --}}
    <main style="padding: 20px;">
        @yield('content')
    </main>

    {{-- Partial Footer --}}
    @include('partials.footer')

    @stack('scripts')
</body>
</html>