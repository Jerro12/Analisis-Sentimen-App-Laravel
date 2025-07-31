<x-app-layout>
    <x-slot name="header">
        <h2 class="font-bold text-2xl text-gray-900 leading-tight">
            Genre: {{ ucfirst($genre) }}
        </h2>
    </x-slot>

    <div class="py-8 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse ($novels as $novel)
                <a href="{{ route('novel.show', $novel->id) }}"
                    class="bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden">
                    <img src="{{ $novel->cover_photo }}" alt="{{ $novel->title }}"
                        class="w-full h-48 object-cover rounded-t-lg">
                    <div class="p-3">
                        <h4 class="text-sm font-bold text-gray-800">{{ $novel->title }}</h4>
                        <p class="text-xs text-gray-500">✍️ {{ $novel->author }}</p>
                    </div>
                </a>
            @empty
                <p class="text-gray-500">Belum ada novel dengan genre ini.</p>
            @endforelse
        </div>
    </div>
</x-app-layout>
