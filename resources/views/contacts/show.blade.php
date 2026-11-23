@extends('layouts.admin')

@section('title', 'Detail Pesan')

@section('content')
<div class="max-w-3xl bg-white rounded-lg shadow-sm border border-gray-100 p-6">
    <div class="flex items-start justify-between border-b border-gray-100 pb-4 mb-4">
        <div>
            <h2 class="text-xl font-bold text-gray-800">{{ $contact->subject }}</h2>
            <p class="text-sm text-gray-600 mt-1">
                Dari: <span class="font-semibold text-gray-800">{{ $contact->name }}</span>
                ({{ $contact->email }})
            </p>
            <p class="text-xs text-gray-400 mt-1">
                Dikirim pada {{ $contact->created_at->format('d M Y, H:i') }}
            </p>
        </div>
        <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-700">
            Sudah dibaca
        </span>
    </div>

    <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-line py-2">
        {{ $contact->message }}
    </div>

    <div class="mt-6 pt-4 border-t border-gray-100">
        <a href="{{ route('contacts.index') }}"
           class="inline-block px-4 py-2 bg-slate-800 text-white text-sm rounded-lg hover:bg-slate-700">
            ← Kembali ke Daftar Pesan
        </a>
    </div>
</div>
@endsection