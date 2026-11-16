@extends('layouts.app')

@section('title', 'Portfolio Projects')

@section('content')
<div class="max-w-6xl mx-auto py-8 px-4">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900">Proyek Saya</h1>
        <p class="text-sm text-gray-500 mt-1">Jelajahi daftar project berdasarkan kata kunci, kategori, teknologi, maupun urutan waktu.</p>
    </div>

    {{-- Form Search, Filter & Sorting (method GET) --}}
    <form method="GET" action="{{ route('portfolio.projects') }}"
          class="bg-white p-4 rounded-xl shadow-sm border border-gray-200 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-5 gap-3">
            {{-- Input Search --}}
            <div class="md:col-span-2">
                <input type="text"
                       name="search"
                       value="{{ request('search') }}"
                       placeholder="Cari judul atau deskripsi project..."
                       class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
            </div>

            {{-- Filter Kategori --}}
            <div>
                <select name="category"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $c)
                        <option value="{{ $c->slug }}" @selected(request('category') === $c->slug)>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Filter Technology (Latihan Modul) --}}
            <div>
                <select name="technology"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua teknologi</option>
                    @foreach ($technologies as $t)
                        <option value="{{ $t->slug }}" @selected(request('technology') === $t->slug)>
                            {{ $t->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sorting --}}
            <div>
                <select name="sort"
                        class="w-full rounded-lg border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="terbaru" @selected(request('sort', 'terbaru') === 'terbaru')>Terbaru</option>
                    <option value="terlama" @selected(request('sort') === 'terlama')>Terlama</option>
                    <option value="judul" @selected(request('sort') === 'judul')>Judul (A - Z)</option>
                    <option value="tanggal" @selected(request('sort') === 'tanggal')>Tanggal Project</option>
                </select>
            </div>
        </div>

        <div class="flex flex-wrap items-center justify-between gap-3 mt-4 pt-3 border-t border-gray-100">
            <p class="text-sm text-gray-600 font-medium">
                {{ $projects->total() }} hasil ditemukan
            </p>

            <div class="flex items-center gap-2">
                @if (request()->hasAny(['search', 'category', 'technology', 'sort']))
                    <a href="{{ route('portfolio.projects') }}"
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-sm font-medium px-4 py-2 rounded-lg transition">
                        Reset
                    </a>
                @endif
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-5 py-2 rounded-lg shadow-sm transition">
                    Cari
                </button>
            </div>
        </div>
    </form>

    {{-- Grid Daftar Project --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse ($projects as $project)
            <article class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col hover:shadow-md transition">
                @if ($project->thumbnail)
                    <a href="{{ route('portfolio.show', $project) }}">
                        <img src="{{ asset('storage/' . $project->thumbnail) }}"
                             alt="{{ $project->title }}"
                             class="w-full h-48 object-cover">
                    </a>
                @else
                    <a href="{{ route('portfolio.show', $project) }}"
                       class="w-full h-48 bg-slate-100 flex items-center justify-center text-slate-400 text-sm">
                        Tidak ada thumbnail
                    </a>
                @endif

                <div class="p-5 flex-1 flex flex-col">
                    <div class="flex flex-wrap items-center gap-2 mb-2">
                        @if ($project->category)
                            <span class="bg-blue-50 text-blue-700 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                {{ $project->category->name }}
                            </span>
                        @endif

                        @if ($project->is_featured)
                            <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                Featured
                            </span>
                        @endif
                    </div>

                    <h2 class="text-lg font-bold text-gray-900 mb-1">
                        <a href="{{ route('portfolio.show', $project) }}" class="hover:text-blue-600 transition">
                            {{ $project->title }}
                        </a>
                    </h2>

                    @if ($project->project_date)
                        <p class="text-xs text-gray-400 mb-2">
                            {{ $project->project_date->format('d M Y') }}
                        </p>
                    @endif

                    <p class="text-sm text-gray-600 mb-4 line-clamp-3 flex-1">
                        {{ $project->short_description ?: \Illuminate\Support\Str::limit($project->description, 110) }}
                    </p>

                    {{-- Badge Technologies --}}
                    @if ($project->technologies->isNotEmpty())
                        <div class="flex flex-wrap gap-1.5 pt-3 border-t border-gray-100">
                            @foreach ($project->technologies as $tech)
                                <span class="bg-gray-100 text-gray-700 text-xs px-2 py-0.5 rounded">
                                    {{ $tech->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </article>
        @empty
            <div class="col-span-full bg-white rounded-xl border border-gray-200 p-10 text-center text-gray-500">
                <p class="text-base font-medium">Tidak ada project yang cocok.</p>
                <p class="text-sm mt-1">Coba ubah kata kunci atau reset filter pencarian.</p>
            </div>
        @endforelse
    </div>

    {{-- Link Pagination (Query String otomatis terjaga oleh withQueryString() di controller) --}}
    <div class="mt-8">
        {{ $projects->links() }}
    </div>
</div>
@endsection