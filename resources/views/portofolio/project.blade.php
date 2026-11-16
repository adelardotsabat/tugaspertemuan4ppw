@extends('layouts.app')

@section('title', $project->title . ' - Portfolio')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <div class="mb-6">
        <a href="{{ route('portfolio.projects') }}"
           class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-blue-600 transition">
            &larr; Kembali ke daftar project
        </a>
    </div>

    <article class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden p-6 md:p-8">
        {{-- Metadata & Badge --}}
        <div class="flex flex-wrap items-center gap-2 mb-3">
            @if ($project->category)
                <span class="bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1 rounded-full">
                    {{ $project->category->name }}
                </span>
            @endif

            @if ($project->is_featured)
                <span class="bg-amber-100 text-amber-800 text-xs font-semibold px-3 py-1 rounded-full">
                    Featured Project
                </span>
            @endif

            @if ($project->project_date)
                <span class="text-xs text-gray-500">
                    &bull; {{ $project->project_date->format('d F Y') }}
                </span>
            @endif
        </div>

        <h1 class="text-3xl font-extrabold text-gray-900 mb-3">{{ $project->title }}</h1>

        @if ($project->short_description)
            <p class="text-base text-gray-600 mb-6">{{ $project->short_description }}</p>
        @endif

        {{-- Tombol External URL --}}
        @if ($project->project_url || $project->repository_url)
            <div class="flex flex-wrap gap-3 mb-6">
                @if ($project->project_url)
                    <a href="{{ $project->project_url }}" target="_blank" rel="noopener noreferrer"
                       class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-sm transition">
                        Kunjungi Live Demo
                    </a>
                @endif

                @if ($project->repository_url)
                    <a href="{{ $project->repository_url }}" target="_blank" rel="noopener noreferrer"
                       class="bg-gray-800 hover:bg-gray-900 text-white text-sm font-medium px-4 py-2 rounded-lg shadow-sm transition">
                        Lihat Repository
                    </a>
                @endif
            </div>
        @endif

        {{-- Thumbnail Utama --}}
        @if ($project->thumbnail)
            <img src="{{ asset('storage/' . $project->thumbnail) }}"
                 alt="{{ $project->title }}"
                 class="w-full max-h-96 object-cover rounded-xl mb-6 border border-gray-100">
        @endif

        {{-- Teknologi yang Digunakan --}}
        @if ($project->technologies->isNotEmpty())
            <div class="mb-6">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Teknologi</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach ($project->technologies as $tech)
                        <span class="bg-slate-100 text-slate-800 text-xs font-medium px-3 py-1 rounded-lg border border-slate-200">
                            {{ $tech->name }}
                        </span>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Deskripsi Lengkap --}}
        <div class="mb-8">
            <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Project</h2>
            <div class="text-gray-700 leading-relaxed whitespace-pre-line text-base">
                {{ $project->description }}
            </div>
        </div>

        {{-- Gallery Gambar Project --}}
        @if ($project->images->isNotEmpty())
            <div class="pt-6 border-t border-gray-100">
                <h2 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Galeri Project</h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    @foreach ($project->images as $img)
                        <figure class="border border-gray-100 rounded-xl overflow-hidden bg-gray-50">
                            <img src="{{ asset('storage/' . $img->image) }}"
                                 alt="{{ $img->caption ?: $project->title }}"
                                 class="w-full h-52 object-cover">
                            @if ($img->caption)
                                <figcaption class="p-3 text-xs text-gray-600">
                                    {{ $img->caption }}
                                </figcaption>
                            @endif
                        </figure>
                    @endforeach
                </div>
            </div>
        @endif
    </article>
</div>
@endsection