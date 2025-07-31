<x-app-layout>
    <div class="py-6 px-4 max-w-4xl mx-auto space-y-8">

        {{-- Kartu Novel --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $novel->title }}</h1>
            <p class="text-sm text-gray-600 mb-4">
                ✍️ {{ $novel->author }} — 🏷️ Genre: {{ $novel->genre }}
            </p>

            {{-- Gambar Cover --}}
            @if ($novel->photo)
                <img src="{{ asset('storage/' . $novel->photo) }}" alt="{{ $novel->title }}"
                    class="w-full max-h-52 object-contain mb-4 rounded">
            @endif

            <div class="text-gray-800 space-y-1">
                <p>📅 Tahun Terbit: {{ $novel->year }}</p>
                <p>📄 Jumlah Halaman: {{ $novel->pages }}</p>
            </div>

            {{-- Sinopsis --}}
            @if (!empty($novel->synopsis))
                <div class="mt-6">
                    <h2 class="text-lg font-semibold text-gray-700 mb-2">📝 Sinopsis</h2>
                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">
                        {{ $novel->synopsis }}
                    </p>
                </div>
            @endif

            @auth
                <form method="POST" action="{{ route('bookmark.toggle') }}">
                    @csrf
                    <input type="hidden" name="novel_id" value="{{ $novel->id }}">

                    <button type="submit"
                        class="mt-4 flex items-center gap-2 px-4 py-2 rounded text-sm font-medium transition
                @if (auth()->user()->bookmarks->contains($novel->id)) bg-yellow-400 text-black hover:bg-yellow-500
                @else bg-indigo-600 text-white hover:bg-indigo-700 @endif">

                        @if (auth()->user()->bookmarks->contains($novel->id))
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v12l7-3 7 3V5a2 2 0 00-2-2H5z" />
                            </svg>
                            Disimpan
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5 5v14l7-5 7 5V5a2 2 0 00-2-2H7a2 2 0 00-2 2z" />
                            </svg>
                            Simpan
                        @endif
                    </button>
                </form>
            @endauth
        </div>

        {{-- Form Komentar --}}
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold mb-3">💬 Tinggalkan Komentar</h2>

            <form method="POST" action="{{ route('novel.comment', $novel->id) }}">
                @csrf
                <textarea name="comment" rows="3" required
                    class="w-full border border-gray-300 rounded-lg p-3 focus:ring focus:ring-blue-300"
                    placeholder="Tulis komentar Anda..."></textarea>

                <button type="submit"
                    class="mt-3 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    Kirim Komentar
                </button>
            </form>
        </div>
        {{-- Daftar Komentar --}}
        @if ($novel->comments->count())
            <div x-data="{ showAll: false }" class="space-y-6">
                <h2 class="text-lg font-semibold text-gray-800">🗣 Komentar Pembaca</h2>

                @foreach ($novel->comments as $index => $comment)
                    <div x-show="showAll || {{ $index }} < 3"
                        class="bg-white border rounded-xl shadow-sm p-4 flex items-start gap-3 hover:shadow-md transition-shadow"
                        x-transition>

                        {{-- Avatar --}}
                        <img src="{{ $comment->user->profile_photo }}" alt="Foto {{ $comment->user->name }}"
                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border shadow-sm">

                        {{-- Isi Komentar --}}
                        <div class="flex-1">
                            {{-- Header --}}
                            <div class="flex justify-between items-center mb-1">
                                <h4 class="text-sm sm:text-base font-semibold text-gray-800">
                                    {{ $comment->user->name }}
                                </h4>
                                <span class="text-xs text-gray-500 whitespace-nowrap">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>
                            </div>

                            {{-- Konten --}}
                            <p class="text-sm sm:text-[15px] text-gray-700 leading-relaxed mb-1">
                                {{ $comment->content }}
                            </p>

                            {{-- Sentimen --}}
                            <div class="text-xs sm:text-sm text-gray-600 mt-1 flex flex-wrap gap-x-2 items-center">
                                <span>🧠 Sentimen:</span>
                                <span
                                    class="@if ($comment->sentiment === 'positive') text-green-600 
                                     @elseif($comment->sentiment === 'negative') text-red-600 
                                     @else text-yellow-600 @endif font-semibold">
                                    {{ ucfirst($comment->sentiment) }}
                                </span>

                                @if (!is_null($comment->score))
                                    <span>(skor: {{ number_format($comment->score, 3) }})</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- Tombol Lihat Semua --}}
                @if ($novel->comments->count() > 3)
                    <div class="text-center">
                        <button @click="showAll = !showAll"
                            class="text-sm text-blue-600 hover:underline mt-2 font-medium">
                            <span x-show="!showAll">🔽 Lihat Semua Komentar</span>
                            <span x-show="showAll">🔼 Sembunyikan Komentar</span>
                        </button>
                    </div>
                @endif
            </div>
        @endif


        {{-- Rekomendasi Berdasarkan Komentar --}}
        @if (auth()->check())
            <div class="bg-white rounded-xl shadow p-6 space-y-4">
                <h2 class="text-lg font-semibold text-gray-800">📚 Rekomendasi Berdasarkan Komentar Anda</h2>

                @if ($recommendations && $recommendations['novels']->count())
                    <div class="flex items-center gap-3">
                        <img src="{{ $recommendations['comment']->user->profile_photo }}"
                            alt="Foto {{ $recommendations['comment']->user->name }}"
                            class="w-10 h-10 sm:w-12 sm:h-12 rounded-full object-cover border shadow-sm">
                        <div>
                            <p class="text-sm text-gray-600">
                                Berdasarkan komentar terakhir Anda dengan sentimen:
                                <span class="font-semibold text-indigo-600">
                                    {{ ucfirst($recommendations['comment']->sentiment) }}
                                </span>
                            </p>
                            <p class="text-xs text-gray-500">Ditulis oleh:
                                {{ $recommendations['comment']->user->name }}</p>
                        </div>
                    </div>

                    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4 pt-4">
                        @foreach ($recommendations['novels'] as $rec)
                            <a href="{{ route('novel.show', $rec->id) }}"
                                class="flex items-start gap-4 bg-gray-50 border hover:shadow rounded-xl p-4 transition">

                                {{-- Cover Photo --}}
                                @if ($rec->photo)
                                    <img src="{{ asset('storage/' . $rec->photo) }}" alt="Cover {{ $rec->title }}"
                                        class="w-16 h-24 object-cover rounded shadow-sm">
                                @else
                                    <div
                                        class="w-16 h-24 bg-gray-200 flex items-center justify-center text-xs text-gray-500 rounded">
                                        No Image
                                    </div>
                                @endif

                                {{-- Info --}}
                                <div class="flex-1">
                                    <h3 class="text-base font-semibold text-gray-800">{{ $rec->title }}</h3>
                                    <p class="text-sm text-gray-600">✍️ {{ $rec->author }}</p>
                                    <p class="text-xs text-gray-500">🏷️ {{ $rec->genre }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-600 text-sm italic">
                        Belum ada rekomendasi berdasarkan komentar Anda. Coba tinggalkan komentar dulu!
                    </p>
                @endif
            </div>
        @endif

    </div>
</x-app-layout>
