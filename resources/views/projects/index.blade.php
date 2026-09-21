@extends('layouts.app')

@section('content')
<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Daftar Project</h2>
        <a href="{{ route('projects.create') }}" class="btn btn-primary">Tambah Project</a>
    </div>

    @if($projects->count() > 0)
        <div class="row">
            @foreach ($projects as $project)
                <div class="col-md-6 mb-3">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $project->title }}</h5>
                            <small class="text-muted">Tanggal: {{ $project->created_at->format('d M Y, H:i') }}</small>
                            <div class="mt-3">
                                <a href="{{ route('projects.show', $project->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">Belum ada data project.</div>
    @endif
</div>
@endsection