<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    // 1. Menggunakan Local Scope published() sesuai Tugas Praktikum 1
    public function index(Request $request)
{
    // Jumlah data per halaman: hanya boleh 5, 10, 25 (default 10)
    $perPage = (int) $request->query('per_page', 10);
    if (!in_array($perPage, [5, 10, 25])) {
        $perPage = 10;
    }

    // Kata kunci pencarian judul
    $search = trim($request->query('search', ''));

    // Tetap pakai Local Scope published() dari praktikum sebelumnya
    $query = Project::published();

    if ($search !== '') {
        $query->where('title', 'like', '%' . $search . '%');
    }

    $projects = $query
        ->latest()
        ->orderByDesc('id') // pembeda kalau created_at sama (data hasil seeder)
        ->paginate($perPage)
        ->withQueryString(); // bawa search & per_page saat pindah halaman

    return view('projects.index', compact('projects', 'search', 'perPage'));
}

    public function create()
    {
        return view('projects.create');
    }

    // 2. Menambahkan validasi field 'status'
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'       => 'required|string|min:5|max:255',
            'description' => 'required|string|min:10',
            'status'      => 'required|in:draft,published', // Tambahan validasi status
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
                           . '|dimensions:min_width=400,min_height=300',
        ]);

        if ($request->hasFile('thumbnail')) {
            $validatedData['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');   // jangan lupa 'public'
        }

        Project::create($validatedData);

        return redirect()->route('projects.index')
                         ->with('success', 'Project berhasil ditambahkan.');
    }

    public function show($id)
    {
        $project = Project::with('images')->findOrFail($id);
        return view('projects.show', compact('project'));
    }

    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        return view('projects.edit', compact('project'));
    }

    // 3. Menambahkan validasi field 'status' saat update
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title'       => 'required|string|min:5|max:255',
            'description' => 'required|string|min:10',
            'status'      => 'required|in:draft,published', // Tambahan validasi status
            'thumbnail'   => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
                           . '|dimensions:min_width=400,min_height=300',
        ]);

        $project = Project::findOrFail($id);

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);   // hapus file lama
            }
            $validatedData['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $project->update($validatedData);

        return redirect()->route('projects.index')
                         ->with('success', 'Project berhasil diperbarui.');
    }

    // 4. Soft Delete (Memindahkan ke sampah)
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')
                         ->with('success', 'Project berhasil dipindahkan ke sampah.');
    }

    // =========================================================
    // METHOD TAMBAHAN UNTUK TUGAS PRAKTIKUM 2 (SOFT DELETES)
    // =========================================================

    // 5. Menampilkan halaman sampah (data terhapus)
    public function trash()
    {
        $trashedProjects = Project::onlyTrashed()->latest()->get();
        return view('projects.trash', compact('trashedProjects'));
    }

    // 6. Restore data dari sampah
    public function restore(string $id)
    {
        $project = Project::withTrashed()->findOrFail($id);
        $project->restore();

        return redirect()->route('projects.trash')
                         ->with('success', 'Project berhasil dipulihkan.');
    }

    // 7. Hapus permanen dari database
    public function forceDelete(string $id)
    {
        $project = Project::withTrashed()->with('images')->findOrFail($id);

        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }
        foreach ($project->images as $image) {
                Storage::disk('public')->delete($image->image);
        }

        $project->forceDelete();

        return redirect()->route('projects.trash')
                         ->with('success', 'Project berhasil dihapus secara permanen.');
    }
}