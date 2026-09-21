@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="card shadow-sm">
        <div class="card-body">
            <h2 class="card-title">{{ $project->title }}</h2>
            <p class="text-muted">Dibuat pada: {{ $project->created_at->format('d M Y, H:i') }}</p>
            <hr>
            <p class="card-text">{{ $project->description }}</p>
            <a href="{{ route('projects.index') }}" class="btn btn-secondary mt-3">Kembali ke Daftar Project</a>
        </div>
    </div>
</div>
@endsection