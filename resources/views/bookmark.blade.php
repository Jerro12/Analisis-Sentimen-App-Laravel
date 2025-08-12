<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h2 class="text-xl font-semibold mb-4">📌 Daftar Bookmark</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-6">
            @forelse ($bookmarks as $novel)
                <div class="relative bg-white shadow rounded-xl overflow-hidden hover:shadow-lg transition duration-300">
                    {{-- Link ke detail --}}
                    <a href="{{ route('novel.show', ['id' => $novel->id, 'from' => 'bookmark']) }}" class="block">
                        {{-- Cover lebih kecil --}}
                        @if ($novel->photo)
                            <img src="{{ asset('storage/' . $novel->photo) }}" alt="{{ $novel->title }}"
                                class="w-full h-40 object-cover object-center" />
                        @else
                            <img src="{{ asset('images/default-novel.png') }}" alt="Default Cover"
                                class="w-full h-40 object-cover object-center" />
                        @endif

                        {{-- Info --}}
                        <div class="p-3">
                            <h3 class="text-md font-semibold text-gray-800 truncate">{{ $novel->title }}</h3>
                            <p class="text-sm text-gray-600 truncate">✍️ {{ $novel->author }}</p>
                            <p class="text-xs text-gray-500 mt-1 truncate">🏷️ {{ $novel->genre }}</p>
                        </div>
                    </a>

                    {{-- Tombol hapus --}}
                    <form action="{{ route('bookmarks.destroy', $novel->id) }}" method="POST"
                        class="absolute top-2 right-2 z-10">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Hapus Bookmark"
                            class="text-gray-500 hover:text-red-600 transition duration-200 p-1 bg-white/80 rounded-full shadow-sm hover:shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                class="h-5 w-5">
                                <path d="M5 3a2 2 0 0 0-2 2v16l9-4 9 4V5a2 2 0 0 0-2-2H5z" />
                            </svg>
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full text-center text-gray-500 py-12">
                    <p class="text-lg">📭 Belum ada bookmark disimpan.</p>
                    <p class="text-sm mt-2">Temukan novel menarik dan simpan ke daftar bookmark kamu!</p>
                </div>
            @endforelse
        </div>
    </div>
</x-app-layout>
