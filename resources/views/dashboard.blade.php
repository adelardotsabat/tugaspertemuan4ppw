@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard</h2>

<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <x-stat-card label="Projects" :value="$totalProjects" />
    <x-stat-card label="Categories" :value="$totalCategories" color="text-green-600" />
    <x-stat-card label="Technologies" :value="$totalTechnologies" color="text-purple-600" />
    <x-stat-card label="Skills" :value="$totalSkills" color="text-orange-600" />
</div>

<h3 class="text-lg font-semibold text-gray-800 mb-3">5 Project Terbaru</h3>
<ul class="space-y-2">
    @forelse($latestProjects as $project)
        <li class="text-sm text-gray-700">{{ $project->title }}</li>
    @empty
        <li class="text-sm text-gray-500">Belum ada project.</li>
    @endforelse
</ul>
@endsection