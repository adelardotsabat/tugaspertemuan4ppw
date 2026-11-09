@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <x-stat-card label="Projects" :value="$totalProjects" />
    <x-stat-card label="Categories" :value="$totalCategories" color="text-green-600" />
    <x-stat-card label="Technologies" :value="$totalTechnologies" color="text-purple-600" />
    <x-stat-card label="Skills" :value="$totalSkills" color="text-orange-600" />
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