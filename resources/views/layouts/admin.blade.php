<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Portfolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div class="min-h-screen flex">

    {{-- Sidebar --}}
    <aside class="w-56 shrink-0 bg-slate-800 text-slate-200 flex flex-col">
        <div class="px-5 py-5 text-lg font-bold text-white border-b border-slate-700">Admin Panel</div>

        <div class="flex-1 px-3 py-4 space-y-1 text-sm">
            <a href="{{ route('dashboard') }}"
               class="block px-3 py-2 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-slate-700 text-white font-semibold' : 'hover:bg-slate-700' }}">
                Dashboard
            </a>
            <a href="{{ route('projects.index') }}"
               class="block px-3 py-2 rounded-lg {{ request()->routeIs('projects.index', 'projects.create', 'projects.edit', 'projects.show') ? 'bg-slate-700 text-white font-semibold' : 'hover:bg-slate-700' }}">
                Projects
            </a>
            <a href="{{ route('projects.trash') }}"
               class="block px-3 py-2 rounded-lg {{ request()->routeIs('projects.trash') ? 'bg-slate-700 text-white font-semibold' : 'hover:bg-slate-700' }}">
                Trash
            </a>
        </div>

        <div class="px-3 py-4 border-t border-slate-700 text-sm">
            <a href="{{ route('home') }}" class="block px-3 py-2 rounded-lg hover:bg-slate-700">← Lihat Website</a>
        </div>
    </aside>

    {{-- Konten + navbar atas --}}
    <div class="flex-1 min-w-0 flex flex-col">
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between">
            <h1 class="text-base font-semibold text-gray-700">@yield('title', 'Admin')</h1>
            <div class="flex items-center gap-3 text-sm text-gray-600">
                <span>Halo, {{ Auth::user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-red-600 hover:text-red-800">Logout</button>
                </form>
            </div>
        </header>

        <div class="p-6">
            @yield('content')
        </div>
    </div>
</div>
@stack('scripts')
</body>
</html>