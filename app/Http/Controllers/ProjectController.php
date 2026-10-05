<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    // 1. Menggunakan Local Scope published() sesuai Tugas Praktikum 1
    public function index()
    {
        $projects = Project::published()->latest()->get();
        return view('projects.index', compact('projects'));
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
        ]);

        Project::create($validatedData);

        return redirect()->route('projects.index')
                         ->with('success', 'Project berhasil ditambahkan.');
    }

    public function show($id)
    {
        $project = Project::findOrFail($id);
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
        ]);

        $project = Project::findOrFail($id);
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
        $project = Project::withTrashed()->findOrFail($id);
        $project->forceDelete();

        return redirect()->route('projects.trash')
                         ->with('success', 'Project berhasil dihapus secara permanen.');
    }
}