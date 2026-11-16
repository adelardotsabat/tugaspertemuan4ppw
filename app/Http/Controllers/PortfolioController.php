<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    public function projects(Request $request)
    {
        $query = Project::with(['category', 'technologies'])
            ->where('status', 'published')
            ->when($request->search, fn ($q, $s) =>
                $q->where(fn ($w) => $w->where('title', 'like', "%{$s}%")
                    ->orWhere('short_description', 'like', "%{$s}%")
                    ->orWhere('description', 'like', "%{$s}%")))
            ->when($request->category, fn ($q, $c) =>
                $q->whereHas('category', fn ($w) => $w->where('slug', $c)))
            ->when($request->technology, fn ($q, $t) =>
                $q->whereHas('technologies', fn ($w) => $w->where('slug', $t)));

        switch ($request->query('sort')) {
            case 'terlama':
                $query->oldest();
                break;
            case 'az':
            case 'judul':
                $query->orderBy('title');
                break;
            case 'tanggal':
                $query->orderByDesc('project_date');
                break;
            default:
                $query->latest();
        }

        $projects = $query->paginate(9)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $technologies = Technology::orderBy('name')->get();

        return view('projects', compact('projects', 'categories', 'technologies'));
    }

    public function show(Project $project)
    {
        abort_if($project->status !== 'published', 404);

        $project->load('category', 'technologies', 'images');

        return view('portofolio.project', compact('project'));
    }
}