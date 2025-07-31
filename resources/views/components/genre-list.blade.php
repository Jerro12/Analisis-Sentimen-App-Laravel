@props(['genres'])

<div class="mt-6 grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
    @forelse ($genres as $genre)
        <a href="{{ route('genre.show', $genre->slug) }}"
            class="bg-indigo-100 hover:bg-indigo-200 text-indigo-800 text-sm font-medium px-3 py-2 rounded-lg text-center">
            {{ $genre->name }}
        </a>
    @empty
        <p class="text-gray-500 col-span-full">Genre belum tersedia.</p>
    @endforelse
</div>
