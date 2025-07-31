<x-app-layout>
    <x-table-wrapper>
        <h2 class="text-xl font-semibold mb-4">📌 Daftar Bookmark</h2>

        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-5 mt-6">
            @forelse ($bookmarks as $novel)
                <a href="{{ route('novel.show', ['id' => $novel->id, 'from' => 'bookmark']) }}"
                    class="relative bg-white shadow rounded-lg overflow-hidden hover:shadow-lg transition duration-300 block">

                    {{-- Cover Novel --}}
                    @if ($novel->photo)
                        <img src="{{ asset('storage/' . $novel->photo) }}" alt="{{ $novel->title }}"
                            class="w-full h-32 object-cover object-center" />
                    @else
                        <img src="{{ asset('images/default-novel.png') }}" alt="Default Cover"
                            class="w-full h-32 object-cover object-center" />
                    @endif

                    {{-- Info Novel --}}
                    <div class="p-4 pb-12"> {{-- Tambahkan padding bawah agar tidak tertimpa tombol --}}
                        <h3 class="text-md font-semibold text-gray-800 truncate">{{ $novel->title }}</h3>
                        <p class="text-sm text-gray-600">✍️ {{ $novel->author }}</p>
                        <p class="text-xs text-gray-500 mt-1">🏷️ {{ $novel->genre }}</p>
                    </div>

                    {{-- Tombol Bookmark (hapus) --}}
                    <form action="{{ route('bookmarks.destroy', $novel->id) }}" method="POST"
                        class="absolute bottom-3 right-3 z-10">
                        @csrf
                        @method('DELETE')
                        <button type="submit" title="Hapus Bookmark"
                            class="text-black hover:text-gray-700 transition duration-150 ease-in-out">
                            {{-- Ikon Bookmark Filled --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24"
                                class="h-6 w-6">
                                <path d="M5 3a2 2 0 0 0-2 2v16l9-4 9 4V5a2 2 0 0 0-2-2H5z" />
                            </svg>
                        </button>
                    </form>
                </a>
            @empty
                <p class="col-span-full text-gray-500">Kamu belum punya bookmark.</p>
            @endforelse
        </div>
    </x-table-wrapper>
</x-app-layout>
