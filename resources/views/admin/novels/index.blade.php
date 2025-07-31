@extends('layouts.admin')

@section('content')
    <div class="flex justify-between items-center">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Novel Management') }}
        </h2>
        <a href="{{ route('admin.novels.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Tambah Novel
        </a>
    </div>

    {{-- Filter Form --}}
    <form method="GET" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6 mt-4">
        <x-filter-input label="Cari Judul / Penulis" name="search" type="text" :value="request('search')"
            placeholder="Contoh: Laskar Pelangi" />

        <x-filter-input label="Genre" name="genre" type="select" :value="request('genre')" :options="['fantasi', 'romansa', 'petualangan', 'horor', 'drama']" />

        <div class="flex items-end">
            <x-primary-button class="w-full">Filter</x-primary-button>
        </div>
    </form>

    {{-- Table --}}
    <x-table-wrapper>
        <table class="min-w-full divide-y divide-gray-200 text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Foto</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Judul</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Penulis</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Genre</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Sinopsis</th>
                    <th class="px-4 py-2 text-left font-semibold text-gray-600">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
                @forelse ($novels as $novel)
                    <tr>
                        <td class="px-4 py-2">
                            @if ($novel->photo)
                                <img src="{{ asset('storage/' . $novel->photo) }}" alt="Cover {{ $novel->title }}"
                                    class="w-16 h-20 object-cover rounded shadow-sm">
                            @else
                                <span class="text-gray-400 italic">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">{{ $novel->title }}</td>
                        <td class="px-4 py-2">{{ $novel->author }}</td>
                        <td class="px-4 py-2">{{ ucfirst($novel->genre) }}</td>
                        <td class="px-4 py-2">
                            {{ \Illuminate\Support\Str::limit(strip_tags($novel->synopsis), 80, '...') }}
                        </td>
                        <td class="px-4 py-2 space-x-2">
                            <a href="{{ route('admin.novels.edit', $novel) }}">
                                <x-secondary-button>Edit</x-secondary-button>
                            </a>
                            <form action="{{ route('admin.novels.destroy', $novel) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <x-danger-button onclick="return confirm('Yakin ingin menghapus novel ini?')">
                                    Hapus
                                </x-danger-button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-3 text-center text-gray-500">Tidak ada data novel ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </x-table-wrapper>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $novels->withQueryString()->links() }}
    </div>
@endsection
