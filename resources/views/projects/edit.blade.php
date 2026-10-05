@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-1">Edit Project</h2>
        <p class="text-sm text-gray-500 mb-6">Ubah data project portofolio Anda.</p>

        <form action="{{ route('projects.update', $project->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <!-- Title Input -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title Project</label>
                <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" 
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('title') border-red-500 @enderror" required>
                @error('title')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description Input -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" id="description" rows="4" 
                          class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror" required>{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status Input (Tugas Praktikum 1) -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status Project</label>
                <select name="status" id="status" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('status') border-red-500 @enderror" required>
                    <option value="published" {{ old('status', $project->status) == 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ old('status', $project->status) == 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
                @error('status')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="flex items-center gap-3 pt-3">
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-5 py-2.5 rounded-lg shadow transition">
                    Update Project
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