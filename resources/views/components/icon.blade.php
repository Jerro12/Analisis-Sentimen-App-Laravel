@props(['name', 'class' => 'w-5 h-5'])

@php
    $icons = [
        'home' => 'M3 9.75L12 3l9 6.75v10.5A1.75 1.75 0 0 1 19.25 22H4.75A1.75 1.75 0 0 1 3 20.25V9.75z M9 22V12h6v10',
        'search' => 'M21 21l-4.35-4.35m0 0A7.5 7.5 0 1 0 6 6a7.5 7.5 0 0 0 10.65 10.65z',
        'bookmark' => 'M5 3a2 2 0 0 0-2 2v16l7-5 7 5V5a2 2 0 0 0-2-2H5z',
        'user' =>
            'M15.75 11.25A3.75 3.75 0 1 1 8.25 11.25 3.75 3.75 0 0 1 15.75 11.25z M4.5 20.25v-.75A6.75 6.75 0 0 1 11.25 12.75h1.5A6.75 6.75 0 0 1 19.5 19.5v.75',
        'logout' =>
            'M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-9A2.25 2.25 0 0 0 2.25 5.25v13.5A2.25 2.25 0 0 0 4.5 21h9a2.25 2.25 0 0 0 2.25-2.25V15M12 9l3-3m0 0l-3-3m3 3H8.25',
        // Tambahkan ikon lain di sini jika perlu
    ];
@endphp

<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
    {{ $attributes->merge(['class' => $class]) }}>
    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icons[$name] ?? '' }}" />
</svg>
