@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-2xl mx-auto py-8 px-4">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Profil Saya</h2>

    <dl class="space-y-2 text-sm text-gray-700">
        <div>
            <dt class="font-semibold">Nama</dt>
            <dd>{{ Auth::user()->name }}</dd>
        </div>
        <div>
            <dt class="font-semibold">Email</dt>
            <dd>{{ Auth::user()->email }}</dd>
        </div>
        <div>
            <dt class="font-semibold">Terdaftar sejak</dt>
            <dd>{{ Auth::user()->created_at->format('d M Y, H:i') }}</dd>
        </div>
    </dl>
</div>
@endsection