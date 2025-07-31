<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Semua Novel') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">
        {{-- 🔍 Search --}}
        <x-search-bar />

        {{-- 📚 Grid Semua Novel --}}
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5 mt-6">
            @forelse ($novels as $novel)
                {{-- Link ke detail novel --}}
                <a href="{{ route('novel.show', $novel->id) }}" class="block">
                    <div class="bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition duration-300">
                        @if ($novel->photo)
                            <img src="{{ asset('storage/' . $novel->photo) }}" alt="{{ $novel->title }}"
                                class="w-full h-32 object-cover object-center" />
                        @else
                            <img src="{{ asset('images/default-novel.png') }}" alt="Default Cover"
                                class="w-full h-32 object-cover object-center" />
                        @endif
                        <div class="p-4">
                            <h3 class="text-md font-semibold text-gray-800 truncate">{{ $novel->title }}</h3>
                            <p class="text-sm text-gray-600">✍️ {{ $novel->author }}</p>
                            <p class="text-xs text-gray-500 mt-1">🏷️ {{ $novel->genre }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <p class="col-span-full text-gray-500">Tidak ada novel ditemukan.</p>
            @endforelse
        </div>

    </div>
</x-app-layout>
