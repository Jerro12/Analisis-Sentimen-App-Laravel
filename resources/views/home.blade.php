@php use Illuminate\Support\Str; @endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 leading-tight">
            👋 Halo, {{ Auth::user()->name }}
        </h2>
        <p class="text-sm text-gray-500">Selamat datang kembali. Temukan bacaan baru yang menarik untukmu.</p>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto space-y-12">

        {{-- 🔍 Search Bar --}}
        <div class="mt-4">
            <x-search-bar />
        </div>

        {{-- ✅ Rekomendasi Personal (opsional jika tersedia) --}}
        @if (isset($recommendations) && $recommendations['novels']->count())
            <div>
                <h3 class="text-lg font-semibold text-gray-800 mb-4">📚 Rekomendasi untuk Anda</h3>
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-4">
                    @foreach ($recommendations['novels'] as $rec)
                        <a href="{{ route('novel.show', $rec->id) }}"
                            class="bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden">
                            <img src="{{ $rec->cover_photo }}" alt="{{ $rec->title }}"
                                class="w-full h-48 object-cover rounded-t-lg">
                            <div class="p-3">
                                <h4 class="text-sm font-bold text-gray-800">{{ $rec->title }}</h4>
                                <p class="text-xs text-gray-500">✍️ {{ $rec->author }}</p>
                                <p class="text-xs text-gray-400 mt-1">🏷️ {{ $rec->genre }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @elseif (isset($recommendations))
            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 rounded-md">
                <p class="text-sm text-yellow-800">Belum ada rekomendasi berdasarkan komentar Anda. Coba tinggalkan
                    komentar dulu!</p>
            </div>
        @endif

        {{-- 🎠 Carousel Novel Terbaru --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">🆕 Novel Terbaru</h3>
            <x-carousel :novels="$latestNovels" />
        </div>

        {{-- 🧩 Jelajahi Berdasarkan Genre --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">🎭 Jelajahi Berdasarkan Genre</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach ($genres as $genre)
                    <a href="{{ route('genre.show', Str::slug($genre)) }}"
                        class="block bg-white border rounded-lg px-4 py-3 text-center shadow-sm hover:shadow-md transition duration-200">
                        <span class="text-sm font-medium text-gray-700">{{ $genre }}</span>
                    </a>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
