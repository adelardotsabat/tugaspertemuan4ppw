@extends('layouts.admin')

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

    <!-- Form Pencarian + Filter Status + Pilihan Jumlah Data per Halaman -->
    <form method="GET" action="{{ route('projects.index') }}"
          class="flex flex-wrap items-center justify-between gap-3 mb-6">
        <div class="flex flex-wrap items-center gap-2">
            <input type="text" name="search" value="{{ $search }}"
                   placeholder="Cari judul project..."
                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

            <select name="status" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm bg-white focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="">Semua Status</option>
                <option value="published" @selected(($status ?? '') === 'published')>Published</option>
                <option value="draft" @selected(($status ?? '') === 'draft')>Draft</option>
            </select>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                Cari
            </button>

            @if($search !== '' || ($status ?? '') !== '')
                <a href="{{ route('projects.index', ['per_page' => $perPage]) }}"
                   class="text-sm text-gray-500 hover:text-gray-700 px-2">Reset</a>
            @endif
        </div>

        <div class="flex items-center gap-2 text-sm text-gray-600">
            <label for="per_page">Data per halaman:</label>
            <select name="per_page" id="per_page" onchange="this.form.submit()"
                    class="border border-gray-300 rounded-lg px-2 py-1.5 text-sm">
                @foreach([5, 10, 25] as $n)
                    <option value="{{ $n }}" @selected($perPage == $n)>{{ $n }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <!-- Cards List -->
    <div class="space-y-4">
        @forelse($projects as $project)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex justify-between items-center hover:shadow-md transition">
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <p class="text-xs text-blue-600 font-medium">
                            Nomor urut {{ $projects->firstItem() + $loop->index }}
                        </p>
                        <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $project->status === 'published' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' }}">
                            {{ ucfirst($project->status ?? 'draft') }}
                        </span>
                        @if($project->category)
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                {{ $project->category->name }}
                            </span>
                        @endif
                    </div>

                    <h3 class="text-lg font-semibold text-gray-800 mb-1">{{ $project->title }}</h3>
                    <p class="text-xs text-gray-400 mb-2">Tanggal: {{ $project->created_at->format('d M Y, H:i') }}</p>
                    @if ($project->thumbnail)
                        <img src="{{ asset('storage/' . $project->thumbnail) }}" alt="{{ $project->title }}"
                            class="w-28 h-20 object-cover rounded-lg mb-2">
                    @endif
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
                Belum ada project yang ditemukan.
            </div>
        @endforelse
    </div>

    <!-- Informasi Halaman -->
    <div class="mt-6 text-sm text-gray-600">
        Halaman : {{ $projects->currentPage() }} <br>
        Jumlah Data : {{ $projects->total() }} <br>
        Data Per Halaman : {{ $projects->perPage() }}
    </div>

    <!-- Tautan Pagination -->
    <div class="mt-4">
        {{ $projects->links() }}
    </div>
</div>
@endsection