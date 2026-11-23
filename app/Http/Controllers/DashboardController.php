<?php

namespace App\Http\Controllers;

use App\Models\{Category, Contact, Project, Skill, Technology};

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalProjects'     => Project::count(),
            'totalCategories'   => Category::count(),
            'totalTechnologies' => Technology::count(),
            'totalSkills'       => Skill::count(),
            'latestProjects'    => Project::with('category')->latest()->take(5)->get(),

            // Latihan Mandiri: Published + Draft = Total Projects
            'publishedProjects' => Project::published()->count(),
            'draftProjects'     => Project::where('status', 'draft')->count(),

            // Latihan Mandiri Pertemuan 12: Total & Unread Messages
            'totalMessages'     => Contact::count(),
            'unreadMessages'    => Contact::where('is_read', false)->count(),

            // Latihan Mandiri: withCount() jumlah project per kategori
            'categoryStats'     => Category::withCount('projects')
                                    ->orderByDesc('projects_count')
                                    ->orderBy('name')
                                    ->get(),

            // Latihan Mandiri: Skill Teratas (5 skill terbaru, tiap skill bisa di-edit)
            'topSkills'         => Skill::latest()->take(5)->get(),
        ]);
    }
}