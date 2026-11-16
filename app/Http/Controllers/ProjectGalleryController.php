<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectGalleryController extends Controller
{
    private const MAX_IMAGES = 10;   // batas total gambar gallery per project

    public function store(Request $request, Project $project)
    {
        $request->validate([
            'images'   => 'required|array|max:' . self::MAX_IMAGES,
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096|dimensions:min_width=800',   // lebar minimal 800 px
        ], [
            'images.*.dimensions' => 'Lebar gambar minimal 800 px.',
        ]);

        // Latihan Mandiri: batas 10 gambar per project (hitung yang sudah ada + yang baru diunggah)
        $remaining = self::MAX_IMAGES - $project->images()->count();

        if (count($request->file('images')) > $remaining) {
            return back()->withErrors([
                'images' => 'Maksimal ' . self::MAX_IMAGES . ' gambar per project. '
                          . 'Sisa slot: ' . max($remaining, 0) . '.',
            ]);
        }

        foreach ($request->file('images') as $file) {
            $project->images()->create([
                'image' => $file->store('projects/gallery', 'public'),
            ]);
        }

        return back()->with('success', 'Gambar berhasil diunggah.');
    }

    // Latihan Mandiri: edit caption gallery
    public function update(Request $request, Project $project, ProjectImage $image)
    {
        abort_if($image->project_id !== $project->id, 404);

        $validated = $request->validate([
            'caption' => 'nullable|string|max:255',
        ]);

        $image->update($validated);

        return back()->with('success', 'Caption diperbarui.');
    }

    public function destroy(Project $project, ProjectImage $image)
    {
        abort_if($image->project_id !== $project->id, 404);

        Storage::disk('public')->delete($image->image);   // file fisik dulu
        $image->delete();                                 // baru baris database

        return back()->with('success', 'Gambar dihapus.');
    }
}
