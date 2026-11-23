@extends('layouts.admin')

@section('title', 'Messages')

@section('content')
<div class="mb-6 flex items-center justify-between">
    <h2 class="text-xl font-bold text-gray-800">Pesan Masuk (Contact)</h2>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-x-auto">
    <table class="w-full text-sm text-left">
        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">
            <tr>
                <th class="px-4 py-3">Nama</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Subjek</th>
                <th class="px-4 py-3">Waktu Kirim</th>
                <th class="px-4 py-3">Status</th>
                <th class="px-4 py-3 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($contacts as $contact)
                <tr class="{{ $contact->is_read ? 'bg-white' : 'bg-blue-50/40 font-medium' }}">
                    <td class="px-4 py-3 text-gray-800">{{ $contact->name }}</td>
                    <td class="px-4 py-3 text-gray-600">{{ $contact->email }}</td>
                    <td class="px-4 py-3 text-gray-800">{{ $contact->subject }}</td>
                    <td class="px-4 py-3 text-gray-500">{{ $contact->created_at->format('d M Y, H:i') }}</td>
                    <td class="px-4 py-3">
                        @if($contact->is_read)
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-600">
                                Sudah dibaca
                            </span>
                        @else
                            <span class="px-2.5 py-1 text-xs font-semibold rounded-full bg-amber-100 text-amber-800">
                                Belum dibaca
                            </span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('contacts.show', $contact) }}"
                           class="text-blue-600 hover:text-blue-800 font-medium">
                            Baca Pesan
                        </a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="px-4 py-6 text-center text-gray-500">
                        Belum ada pesan masuk.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $contacts->links() }}
</div>
@endsection