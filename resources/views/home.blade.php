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

        {{-- ✅ Rekomendasi Personal --}}
        @if (auth()->check())
            @if (isset($recommendations) && $recommendations && $recommendations['novels']->count())
                <div class="bg-white rounded-xl shadow-sm border p-6 space-y-4">
                    <div class="flex items-center gap-3 mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">📚 Rekomendasi untuk Anda</h3>
                        <div class="flex items-center gap-2 text-sm text-gray-600 bg-blue-50 px-3 py-1 rounded-full">
                            <span>Berdasarkan sentimen:</span>
                            <span class="font-semibold text-blue-600">
                                {{ ucfirst($recommendations['comment']->sentiment) }}
                            </span>
                        </div>
                    </div>

                    {{-- Carousel Container untuk Rekomendasi --}}
                    <div class="swiper recommendation-swiper">
                        <div class="swiper-wrapper">
                            @foreach ($recommendations['novels'] as $rec)
                                <div class="swiper-slide">
                                    <a href="{{ route('novel.show', $rec->id) }}"
                                        class="bg-white rounded-lg shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group border block">
                                        <div class="relative">
                                            @if ($rec->photo)
                                                <img src="{{ asset('storage/' . $rec->photo) }}"
                                                    alt="{{ $rec->title }}"
                                                    class="w-full aspect-[2/3] object-cover group-hover:scale-105 transition-transform duration-300">
                                            @else
                                                <div
                                                    class="w-full aspect-[2/3] bg-gray-200 flex items-center justify-center text-xs text-gray-500">
                                                    No Image
                                                </div>
                                            @endif
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <h4
                                                class="text-sm font-bold text-gray-800 mb-1 line-clamp-2 group-hover:text-blue-600 transition-colors">
                                                {{ $rec->title }}
                                            </h4>
                                            <p class="text-xs text-gray-600 mb-1">✍️ {{ $rec->author }}</p>
                                            <p
                                                class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded-full inline-block">
                                                🏷️
                                                {{ $rec->genre }}</p>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        {{-- Navigation Buttons --}}
                        <div class="swiper-button-next recommendation-next"></div>
                        <div class="swiper-button-prev recommendation-prev"></div>

                        {{-- Pagination --}}
                        <div class="swiper-pagination recommendation-pagination"></div>
                    </div>

                    <div class="flex items-center gap-2 text-xs text-gray-500 pt-2 border-t">
                        <img src="{{ $recommendations['comment']->user->profile_photo ?? 'https://via.placeholder.com/32' }}"
                            alt="Foto {{ $recommendations['comment']->user->name }}"
                            class="w-6 h-6 rounded-full object-cover">
                        <span>Berdasarkan komentar terakhir Anda</span>
                    </div>
                </div>
            @elseif (isset($recommendations))
                <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6">
                    <div class="flex items-center gap-3">
                        <div class="text-2xl">💭</div>
                        <div>
                            <h3 class="text-lg font-semibold text-yellow-800 mb-1">Belum Ada Rekomendasi</h3>
                            <p class="text-sm text-yellow-700">
                                Tinggalkan komentar di novel untuk mendapatkan rekomendasi personal!
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        @else
            <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
                <div class="flex items-center gap-3">
                    <div class="text-2xl">🔐</div>
                    <div>
                        <h3 class="text-lg font-semibold text-blue-800 mb-1">Login untuk Rekomendasi Personal</h3>
                        <p class="text-sm text-blue-700 mb-3">
                            Dapatkan rekomendasi novel berdasarkan preferensi dan komentar Anda.
                        </p>
                        <a href="{{ route('login') }}"
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            Login Sekarang
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- 🆕 Novel Terbaru dengan Carousel --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-4">🆕 Novel Terbaru</h3>

            {{-- Swiper Container --}}
            <div class="swiper novel-swiper">
                <div class="swiper-wrapper">
                    {{-- Membuat slides, setiap slice berisi 6 novel (2 baris x 3 kolom) --}}
                    @php
                        $novelChunks = $latestNovels->chunk(6);
                    @endphp

                    @foreach ($novelChunks as $chunkIndex => $novels)
                        <div class="swiper-slide">
                            {{-- Baris pertama --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-4">
                                @foreach ($novels->take(3) as $novel)
                                    <a href="{{ route('novel.show', $novel->id) }}"
                                        class="bg-white rounded-md shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group">
                                        <div class="relative">
                                            <img src="{{ asset('storage/' . $novel->photo) }}"
                                                alt="{{ $novel->title }}"
                                                class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300 rounded-t-md">
                                            <div
                                                class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                            </div>
                                        </div>
                                        <div class="p-3">
                                            <h4
                                                class="font-semibold text-gray-800 mb-1 line-clamp-2 text-sm group-hover:text-blue-600 transition-colors">
                                                {{ $novel->title }}
                                            </h4>
                                            <p class="text-xs text-gray-600 mb-1">✍️ {{ $novel->author }}</p>
                                            <p
                                                class="text-[11px] text-gray-500 bg-gray-100 px-2 py-1 rounded-full inline-block">
                                                🏷️ {{ $novel->genre }}
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>

                            {{-- Baris kedua --}}
                            @if ($novels->count() > 3)
                                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach ($novels->skip(3)->take(3) as $novel)
                                        <a href="{{ route('novel.show', $novel->id) }}"
                                            class="bg-white rounded-md shadow-sm hover:shadow-md transition-all duration-300 overflow-hidden group">
                                            <div class="relative">
                                                <img src="{{ asset('storage/' . $novel->photo) }}"
                                                    alt="{{ $novel->title }}"
                                                    class="w-full aspect-[3/4] object-cover group-hover:scale-105 transition-transform duration-300 rounded-t-md">
                                                <div
                                                    class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                                                </div>
                                            </div>
                                            <div class="p-3">
                                                <h4
                                                    class="font-semibold text-gray-800 mb-1 line-clamp-2 text-sm group-hover:text-blue-600 transition-colors">
                                                    {{ $novel->title }}
                                                </h4>
                                                <p class="text-xs text-gray-600 mb-1">✍️ {{ $novel->author }}</p>
                                                <p
                                                    class="text-[11px] text-gray-500 bg-gray-100 px-2 py-1 rounded-full inline-block">
                                                    🏷️ {{ $novel->genre }}
                                                </p>
                                            </div>
                                        </a>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="swiper-pagination"></div>
            </div>
        </div>

        {{-- 🧩 Jelajahi Berdasarkan Genre --}}
        <div>
            <h3 class="text-lg font-semibold text-gray-800 mb-6">🎭 Jelajahi Berdasarkan Genre</h3>
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
                @foreach ($genres as $genre)
                    <a href="{{ route('genre.show', Str::slug($genre)) }}"
                        class="group relative bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl p-6 text-center shadow-sm hover:shadow-md transition-all duration-300 hover:border-blue-300 hover:bg-gradient-to-br hover:from-blue-50 hover:to-white">
                        <div class="mb-3">
                            @switch($genre)
                                @case('romansa')
                                    <div class="text-2xl">💕</div>
                                @break

                                @case('Fantasy')
                                    <div class="text-2xl">🧙‍♂️</div>
                                @break

                                @case('Mystery')
                                    <div class="text-2xl">🕵️</div>
                                @break

                                @case('Sci-Fi')
                                    <div class="text-2xl">🚀</div>
                                @break

                                @case('Horror')
                                    <div class="text-2xl">😱</div>
                                @break

                                @case('Adventure')
                                    <div class="text-2xl">⛰️</div>
                                @break

                                @case('Drama')
                                    <div class="text-2xl">🎭</div>
                                @break

                                @case('Comedy')
                                    <div class="text-2xl">😂</div>
                                @break

                                @default
                                    <div class="text-2xl">📚</div>
                            @endswitch
                        </div>
                        <span
                            class="text-sm font-semibold text-gray-700 group-hover:text-blue-600 transition-colors duration-300">{{ $genre }}</span>
                        <div
                            class="absolute inset-0 rounded-xl bg-blue-500 opacity-0 group-hover:opacity-5 transition-opacity duration-300">
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
