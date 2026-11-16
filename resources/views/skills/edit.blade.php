@extends('layouts.admin')

@section('title', 'Edit Skill')

@section('content')
<div class="max-w-xl mx-auto py-8 px-4">
    <div class="bg-white rounded-xl shadow-md p-6 border border-gray-100">
        <h2 class="text-2xl font-bold text-gray-800 mb-1">Edit Skill</h2>
        <p class="text-sm text-gray-500 mb-6">Ubah nama skill.</p>

        <form action="{{ route('skills.update', $skill->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Skill</label>
                <input type="text" name="name" id="name" value="{{ old('name', $skill->name) }}"
                       class="w-full rounded-lg border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror" required>
                @error('name')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-3">
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-medium text-sm px-5 py-2.5 rounded-lg shadow transition">
                    Update Skill
                </button>
                <a href="{{ route('dashboard') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium text-sm px-5 py-2.5 rounded-lg transition">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
