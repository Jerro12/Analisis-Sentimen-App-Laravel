<div x-data="{ activeSlide: 0 }" class="relative overflow-hidden rounded-lg shadow">
    <div class="flex transition-transform duration-500 ease-in-out"
        :style="'transform: translateX(-' + activeSlide * 100 + '%)'">
        @foreach ($novels as $novel)
            <div class="min-w-full">
                <a href="{{ route('novel.show', $novel->id) }}">
                    <img src="{{ asset('storage/' . $novel->photo) }}" alt="{{ $novel->title }}"
                        class="w-full h-64 object-cover rounded" />
                    <div class="p-4 bg-white">
                        <h4 class="font-semibold text-lg text-gray-800 truncate">{{ $novel->title }}</h4>
                        <p class="text-sm text-gray-600">✍️ {{ $novel->author }}</p>
                    </div>
                </a>
            </div>
        @endforeach
    </div>

    {{-- Navigasi Kiri & Kanan --}}
    <button @click="activeSlide = (activeSlide === 0) ? {{ count($novels) - 1 }} : activeSlide - 1"
        class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-100">
        ◀
    </button>
    <button @click="activeSlide = (activeSlide === {{ count($novels) - 1 }}) ? 0 : activeSlide + 1"
        class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-white p-2 rounded-full shadow hover:bg-gray-100">
        ▶
    </button>
</div>
