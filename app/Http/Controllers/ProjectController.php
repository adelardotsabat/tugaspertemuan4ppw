<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $perPage = (int) $request->query('per_page', 10);
        if (!in_array($perPage, [5, 10, 25])) {
            $perPage = 10;
        }

        $search = trim($request->query('search', ''));

        $query = Project::published();

        if ($search !== '') {
            $query->where('title', 'like', '%' . $search . '%');
        }

        $projects = $query
            ->latest()
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        return view('projects.index', compact('projects', 'search', 'perPage'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('projects.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title'       => 'required|string|min:5|max:255',
            'description' => 'required|string|min:10',
            'status'      => 'required|in:draft,published',
            'category_id' => 'nullable|exists:categories,id',
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
        $project = Project::with(['category', 'images'])->findOrFail($id);
        return view('projects.show', compact('project'));
    }

    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        $categories = Category::orderBy('name')->get();
        return view('projects.edit', compact('project', 'categories'));
    }

    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title'       => 'required|string|min:5|max:255',
            'description' => 'required|string|min:10',
            'status'      => 'required|in:draft,published',
            'category_id' => 'nullable|exists:categories,id',
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

    // Soft delete: file sengaja TIDAK dihapus, karena project masih bisa di-restore
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        return redirect()->route('projects.index')
                         ->with('success', 'Project berhasil dipindahkan ke sampah.');
    }

    public function trash()
    {
        $trashedProjects = Project::onlyTrashed()->latest()->get();
        return view('projects.trash', compact('trashedProjects'));
    }

    public function restore(string $id)
    {
        $project = Project::withTrashed()->findOrFail($id);
        $project->restore();

        return redirect()->route('projects.trash')
                         ->with('success', 'Project berhasil dipulihkan.');
    }

    // Hapus permanen: di sini thumbnail dan semua gambar gallery ikut dihapus dari storage
    public function forceDelete(string $id)
    {
        $project = Project::withTrashed()->with('images')->findOrFail($id);

        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }
        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        $project->forceDelete();   // baris project_images ikut hilang (cascadeOnDelete)

        return redirect()->route('projects.trash')
                         ->with('success', 'Project berhasil dihapus secara permanen.');
    }
}