@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <x-stat-card label="Projects" :value="$totalProjects" />
    <x-stat-card label="Categories" :value="$totalCategories" color="text-green-600" />
    <x-stat-card label="Technologies" :value="$totalTechnologies" color="text-purple-600" />
    <x-stat-card label="Skills" :value="$totalSkills" color="text-orange-600" />
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-6 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Latihan Mandiri: card Published / Draft & Messages --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <x-stat-card label="Published" :value="$publishedProjects" color="text-green-600" />
    <x-stat-card label="Draft" :value="$draftProjects" color="text-yellow-600" />
    <x-stat-card label="Total Messages" :value="$totalMessages" color="text-blue-600" />
    <x-stat-card label="Unread Messages" :value="$unreadMessages" color="text-red-600" />
</div>

{{-- Latihan Mandiri: project per kategori (withCount) + skill teratas --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Project per Kategori</h3>
        <ul class="divide-y divide-gray-100 text-sm">
            @forelse($categoryStats as $category)
                <li class="flex justify-between py-2">
                    <span class="text-gray-700">{{ $category->name }}</span>
                    <span class="font-semibold text-gray-900">{{ $category->projects_count }}</span>
                </li>
            @empty
                <li class="py-2 text-gray-500">Belum ada kategori.</li>
            @endforelse
        </ul>
    </div>

    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Skill Teratas</h3>
        <ul class="divide-y divide-gray-100 text-sm">
            @forelse($topSkills as $skill)
                <li class="flex justify-between items-center py-2">
                    <span class="text-gray-700">{{ $skill->name }}</span>
                    <a href="{{ route('skills.edit', $skill->id) }}"
                       class="text-amber-600 hover:text-amber-800 text-xs font-medium">Edit</a>
                </li>
            @empty
                <li class="py-2 text-gray-500">Belum ada skill.</li>
            @endforelse
        </ul>
    </div>
</div>

<h3 class="text-lg font-semibold text-gray-800 mb-3">5 Project Terbaru</h3>
<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Judul</th>
                <th class="px-4 py-3">Kategori</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3">Dibuat</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($latestProjects as $project)
                <tr>
                    <td class="px-4 py-3 text-gray-800">{{ $project->title }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $project->category->name ?? '-' }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ ucfirst($project->status) }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $project->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-gray-500">Belum ada project.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection