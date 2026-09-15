@extends('layouts.app')

@section('title', 'Projects - Portfolio')

@section('content')
    <h1>Proyek Saya</h1>
    @php
        $projects = ['Website Review Film REVFLIX'];
    @endphp

    <ul>
        @forelse($projects as $project)
            <li>{{ $project }}</li>
        @empty
            <li>Belum ada proyek.</li>
        @endforelse
    </ul>
@endsection