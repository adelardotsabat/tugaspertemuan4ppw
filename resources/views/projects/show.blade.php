@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8 px-4">
    <!-- Header Navigation -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Project</h2>
        <a href="{{ route('projects.index') }}" 
           class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm px-4 py-2 rounded-lg border border-gray-200 transition">
            ← Kembali ke Index
        </a>
    </div>

    <!-- Main Detail Card (Konsisten dengan Index) -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:p-8">
        <!-- Title & Status Badge -->
        <div class="flex flex-wrap items-center justify-between gap-3 border-b border-gray-100 pb-4 mb-6">
            <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $project->title }}</h1>
            
            <!-- Badge Status -->
            @if(($project->status ?? 'published') == 'published')
                <span class="bg-green-100 text-green-700 border border-green-300 text-xs font-semibold px-3 py-1 rounded-full">
                    Published
                </span>
            @else
                <span class="bg-yellow-100 text-yellow-800 border border-yellow-300 text-xs font-semibold px-3 py-1 rounded-full">
                    Draft
                </span>
            @endif
        </div>

        <!-- Metadata Info -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-500 mb-6 bg-gray-50/50 p-4 rounded-xl border border-gray-100">
            <div>
                <span class="font-medium text-gray-700">Dibuat Pada:</span>
                <p class="text-gray-600 mt-0.5">{{ $project->created_at->format('d M Y, H:i') }} WIB</p>
            </div>
            <div>
                <span class="font-medium text-gray-700">Terakhir Diperbarui:</span>
                <p class="text-gray-600 mt-0.5">{{ $project->updated_at->format('d M Y, H:i') }} WIB</p>
            </div>
        </div>

        <!-- Description Content -->
        <div class="mb-8">
            <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-2">Deskripsi Project</h3>
            <div class="text-gray-700 leading-relaxed whitespace-pre-line text-base">
                {{ $project->description }}
            </div>
        </div>

        <!-- Action Buttons Footer -->
        <div class="flex items-center gap-3 pt-6 border-t border-gray-100">
            <a href="{{ route('projects.edit', $project->id) }}" 
               class="bg-amber-500 hover:bg-amber-600 text-white font-medium text-sm px-5 py-2.5 rounded-xl shadow-sm transition">
                Edit Project
            </a>

            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Pindahkan project ke sampah?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-600 hover:bg-red-700 text-white font-medium text-sm px-5 py-2.5 rounded-xl shadow-sm transition">
                    Hapus Project
                </button>
            </form>
        </div>
    </div>
</div>
@endsection