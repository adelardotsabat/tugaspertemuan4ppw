@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h2>Tambah Project Baru</h2>
    
    <form action="{{ route('projects.store') }}" method="POST" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Title Project</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title') }}" required>
            @error('title')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-primary">Simpan Project</button>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection