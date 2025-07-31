@props(['novel'])

<div class="bg-white rounded-lg shadow hover:shadow-md transition overflow-hidden">
    <img src="{{ $novel->cover_url }}" alt="{{ $novel->title }}" class="w-full h-48 object-cover">
    <div class="p-4">
        <h3 class="font-semibold text-gray-800 text-base truncate">{{ $novel->title }}</h3>
        <p class="text-sm text-gray-500 mt-1">
            {{ Str::limit($novel->description, 60) }}
        </p>
    </div>
</div>
