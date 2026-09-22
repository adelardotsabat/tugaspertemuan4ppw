@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-6">
    
    {{-- Header & Tombol Tambah Project --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Project</h1>
        <a href="{{ route('projects.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg shadow transition">
            + Tambah Project
        </a>
    </div>

    {{-- Alert Flash Message --}}
    @if (session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded shadow-sm flex justify-between items-center">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-green-700 font-bold">&times;</button>
        </div>
    @endif

    {{-- List Cards Project --}}
    <div class="space-y-4">
        @forelse ($projects as $project)
            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm hover:shadow-md transition flex flex-col md:flex-row md:items-center justify-between gap-4">
                
                {{-- Info Project (Kiri) --}}
                <div>
                    <h2 class="text-xl font-semibold text-gray-900 mb-1">{{ $project->title }}</h2>
                    <p class="text-xs text-gray-500">
                        Tanggal: {{ \Carbon\Carbon::parse($project->created_at)->format('d M Y, H:i') }}
                    </p>
                    @if(!empty($project->description))
                        <p class="text-sm text-gray-600 mt-2 line-clamp-2">
                            {{ $project->description }}
                        </p>
                    @endif
                </div>

                {{-- Action Buttons (Kanan) --}}
                <div class="flex items-center gap-2 pt-3 md:pt-0 border-t md:border-t-0 border-gray-100">
                    {{-- Tombol Lihat Detail / Show --}}
                    <a href="{{ route('projects.show', $project->id) }}" 
                       class="text-sm bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium px-3 py-1.5 rounded-md transition">
                        Detail
                    </a>

                    {{-- Tombol Edit --}}
                    <a href="{{ route('projects.edit', $project->id) }}" 
                       class="text-sm bg-amber-500 hover:bg-amber-600 text-white font-medium px-3 py-1.5 rounded-md transition">
                        Edit
                    </a>

                    {{-- Tombol Delete (Pakai Form + JS Confirm) --}}
                    <form action="{{ route('projects.destroy', $project->id) }}" 
                          method="POST" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus project {{ $project->title }}?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="text-sm bg-red-600 hover:bg-red-700 text-white font-medium px-3 py-1.5 rounded-md transition">
                            Delete
                        </button>
                    </form>
                </div>

            </div>
        @empty
            <div class="bg-white p-8 rounded-xl border border-gray-200 text-center text-gray-500">
                Belum ada project yang dibuat.
            </div>
        @endforelse
    </div>

</div>
@endsection