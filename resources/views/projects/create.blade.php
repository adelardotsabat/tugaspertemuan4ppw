@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-6">
    <div class="bg-white p-6 rounded-xl border border-gray-200 shadow-sm">
        
        {{-- Header Form --}}
        <div class="border-b border-gray-200 pb-4 mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Tambah Project Baru</h1>
            <p class="text-sm text-gray-500 mt-1">Isi formulir di bawah untuk menambahkan project ke dalam portofolio Anda.</p>
        </div>

        {{-- Form Tambah --}}
        <form action="{{ route('projects.store') }}" method="POST" class="space-y-5">
            @csrf

            {{-- Input Title --}}
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title Project</label>
                <input type="text" 
                       name="title" 
                       id="title" 
                       value="{{ old('title') }}" 
                       placeholder="Masukkan judul project (min. 5 karakter)" 
                       class="w-full px-3.5 py-2 border @error('title') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 transition"
                       required>
                @error('title')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" 
                          id="description" 
                          rows="5" 
                          placeholder="Masukkan deskripsi project (min. 10 karakter)" 
                          class="w-full px-3.5 py-2 border @error('description') border-red-500 @else border-gray-300 @enderror rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm text-gray-900 transition"
                          required>{{ old('description') }}</textarea>
                @error('description')
                    <p class="mt-1.5 text-xs text-red-600 font-medium">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Simpan & Batal --}}
            <div class="flex items-center gap-3 pt-3">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-5 py-2.5 rounded-lg shadow transition">
                    Simpan Project
                </button>
                <a href="{{ route('projects.index') }}" 
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm px-5 py-2.5 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>

    </div>
</div>
@endsection