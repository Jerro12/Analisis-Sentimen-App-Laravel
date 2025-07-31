@props(['novel'])

<div class="min-w-[200px] max-w-[200px] bg-white rounded-lg shadow-md overflow-hidden mr-4">
    <img src="{{ $novel->cover_url }}" alt="{{ $novel->title }}" class="w-full h-48 object-cover">
    <div class="p-3">
        <h3 class="text-sm font-semibold text-gray-800 truncate">{{ $novel->title }}</h3>
        <p class="text-xs text-gray-500 mt-1">
            {{ $novel->positive_comments_count ?? 0 }} komentar positif
        </p>
    </div>
</div>
