@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">
    <!-- Header Navigation -->
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Trash - Sampah Project</h2>
            <p class="text-xs text-gray-500 mt-0.5">Daftar project yang dihapus sementara (Soft Delete).</p>
        </div>
        <a href="{{ route('projects.index') }}" 
           class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm px-4 py-2 rounded-lg border border-gray-200 transition">
            ← Kembali ke daftar project
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-xl mb-6 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <!-- Cards List (Model Kartu Persis seperti Index) -->
    <div class="space-y-4">
        @forelse($trashedProjects as $project)
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5 flex justify-between items-center hover:shadow-md transition">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <h3 class="text-lg font-semibold text-gray-800">{{ $project->title }}</h3>
                        
                        <!-- Badge Status -->
                        @if(($project->status ?? 'published') == 'published')
                            <span class="bg-green-100 text-green-700 border border-green-300 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                Published
                            </span>
                        @else
                            <span class="bg-yellow-100 text-yellow-800 border border-yellow-300 text-xs font-semibold px-2.5 py-0.5 rounded-full">
                                Draft
                            </span>
                        @endif
                    </div>

                    <p class="text-xs text-gray-400 mb-2">Dihapus Pada: {{ $project->deleted_at->format('d M Y, H:i') }} WIB</p>
                    <p class="text-sm text-gray-600 line-clamp-2">{{ $project->description }}</p>
                </div>

                <div class="flex items-center gap-2 shrink-0">
                    <!-- Restore Button -->
                    <form action="{{ route('projects.restore', $project->id) }}" method="POST">
                        @csrf
                        <button type="submit" 
                                class="bg-green-600 hover:bg-green-700 text-white text-xs font-medium px-3.5 py-2 rounded-lg shadow-sm transition">
                            Restore
                        </button>
                    </form>

                    <!-- Permanent Delete Button -->
                    <form action="{{ route('projects.forceDelete', $project->id) }}" method="POST" onsubmit="return confirm('Hapus permanen project ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-3.5 py-2 rounded-lg shadow-sm transition">
                            Delete Permanent
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-2xl border border-gray-100 p-8 text-center text-gray-500 shadow-sm">
                Tidak ada data di dalam sampah.
            </div>
        @endforelse
    </div>
</div>
@endsection