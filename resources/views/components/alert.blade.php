@props(['type' => 'success'])

@php
    $base = 'px-4 py-3 rounded mb-4 text-sm';
    $styles = [
        'success' => 'bg-green-100 border border-green-400 text-green-700',
        'error' => 'bg-red-100 border border-red-400 text-red-700',
        'info' => 'bg-blue-100 border border-blue-400 text-blue-700',
        'warning' => 'bg-yellow-100 border border-yellow-400 text-yellow-700',
    ];
@endphp

@if (session($type))
    <div class="{{ $base }} {{ $styles[$type] }}">
        {{ session($type) }}
    </div>
@endif
