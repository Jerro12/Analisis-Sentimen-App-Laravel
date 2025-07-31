@props(['label', 'name', 'type' => 'text', 'value' => '', 'options' => []])

<div>
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-1">
        {{ $label }}
    </label>

    @if ($type === 'select')
        <select name="{{ $name }}" id="{{ $name }}"
            {{ $attributes->merge(['class' => 'w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500']) }}>
            <option value="">Semua</option>
            @foreach ($options as $option)
                <option value="{{ $option }}" @if ($value == $option) selected @endif>
                    {{ ucfirst($option) }}
                </option>
            @endforeach
        </select>
    @else
        <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}"
            {{ $attributes->merge(['class' => 'w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500']) }} />
    @endif
</div>
