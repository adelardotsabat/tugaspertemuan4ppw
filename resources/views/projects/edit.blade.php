@extends('layouts.admin')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-1">Edit Project</h2>
        <p class="text-sm text-gray-500 mb-6">Ubah data project portofolio Anda.</p>

        <form action="{{ route('projects.update', $project->id) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
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

            <!-- Category Input -->
            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori (opsional)</label>
                <select name="category_id" id="category_id" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('category_id') border-red-500 @enderror">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $project->category_id) == $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Short Description Input -->
            <div>
                <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">Ringkasan Singkat (opsional)</label>
                <input type="text" name="short_description" id="short_description" value="{{ old('short_description', $project->short_description) }}" 
                       placeholder="Ringkasan 1-2 kalimat untuk tampilan card (maks. 255 karakter)"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('short_description') border-red-500 @enderror">
                @error('short_description')
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

            <!-- Technologies Checkboxes -->
            @php
                $selectedTechs = old('technologies', $project->technologies->pluck('id')->toArray());
            @endphp
            <div>
                <span class="block text-sm font-medium text-gray-700 mb-1">Teknologi yang Digunakan (opsional)</span>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-2 p-3 border border-gray-200 rounded-lg bg-gray-50/50">
                    @forelse($technologies as $tech)
                        <label class="inline-flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                            <input type="checkbox" name="technologies[]" value="{{ $tech->id }}"
                                   @checked(in_array($tech->id, $selectedTechs))
                                   class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                            <span>{{ $tech->name }}</span>
                        </label>
                    @empty
                        <p class="text-xs text-gray-400 col-span-full">Belum ada data teknologi.</p>
                    @endforelse
                </div>
                @error('technologies')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
                @error('technologies.*')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Status & Project Date -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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

                <div>
                    <label for="project_date" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Project (opsional)</label>
                    <input type="date" name="project_date" id="project_date" value="{{ old('project_date', optional($project->project_date)->format('Y-m-d')) }}"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('project_date') border-red-500 @enderror">
                    @error('project_date')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Project URL & Repository URL -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="project_url" class="block text-sm font-medium text-gray-700 mb-1">URL Live Demo (opsional)</label>
                    <input type="url" name="project_url" id="project_url" value="{{ old('project_url', $project->project_url) }}"
                           placeholder="https://contoh-demo.com"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('project_url') border-red-500 @enderror">
                    @error('project_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="repository_url" class="block text-sm font-medium text-gray-700 mb-1">URL Repository (opsional)</label>
                    <input type="url" name="repository_url" id="repository_url" value="{{ old('repository_url', $project->repository_url) }}"
                           placeholder="https://github.com/username/repo"
                           class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('repository_url') border-red-500 @enderror">
                    @error('repository_url')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Is Featured Checkbox -->
            <div>
                <label class="inline-flex items-center gap-2 text-sm text-gray-700 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $project->is_featured))
                           class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <span>Jadikan Project Unggulan (Featured)</span>
                </label>
            </div>

            <!-- Thumbnail Input -->
            <div>
                <label for="thumbnail" class="block text-sm font-medium text-gray-700 mb-1">Thumbnail</label>
                @if ($project->thumbnail)
                    <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}"
                        class="h-24 rounded border border-gray-200 object-cover mb-2">
                @endif
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                    class="w-full text-sm text-gray-600 border border-gray-300 rounded-lg">
                @error('thumbnail')
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