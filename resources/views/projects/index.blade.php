@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">
    <!-- Header dengan Tombol Tambah & Trash -->
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Daftar Project</h2>
        <div class="flex items-center gap-2">
            <a href="{{ route('projects.trash') }}" 
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm px-4 py-2.5 rounded-lg border border-gray-300 transition flex items-center gap-1">
                🗑️ Lihat Trash
            </a>
            <a href="{{ route('projects.create') }}" 
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-4 py-2.5 rounded-lg shadow transition">
                + Tambah Project
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6">
            {{ session('success') }}
        </div>
    @endif

    <!-- Cards List -->
    <div class="space-y-4">
        @forelse($projects as $project)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex justify-between items-center hover:shadow-md transition">
                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $project->title }}</h3>
                    <p class="text-xs text-gray-400 mb-2">Tanggal: {{ $project->created_at->format('d M Y, H:i') }}</p>
                    <p class="text-sm text-gray-600">{{ $project->description }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <a href="{{ route('projects.show', $project->id) }}" 
                       class="bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs font-medium px-3 py-1.5 rounded-md transition">
                        Detail
                    </a>
                    <a href="{{ route('projects.edit', $project->id) }}" 
                       class="bg-amber-500 hover:bg-amber-600 text-white text-xs font-medium px-3 py-1.5 rounded-md transition">
                        Edit
                    </a>
                    <form action="{{ route('projects.destroy', $project->id) }}" method="POST" onsubmit="return confirm('Pindahkan project ke sampah?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-3 py-1.5 rounded-md transition">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="bg-white rounded-xl border border-gray-100 p-8 text-center text-gray-500">
                Belum ada project yang dipublikasikan.
            </div>
        @endforelse
    </div>
</div>
@endsection