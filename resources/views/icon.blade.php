@php
use \Illuminate\Support\Str;
@endphp

@props([
    'icon' => '',
    'size' => 5,
    'color' => '',
    'class' => $attributes->get('class')
])

@php

$color = $color ? "color: $color;" : '';

if (Str::startsWith($icon, 'heroicons.outline.')) {
    $icon = Str::replaceFirst('heroicons.outline.', 'heroicons-outline:', $icon);
} else if (Str::startsWith($icon, 'heroicons.')) {
    $icon = Str::replaceFirst('heroicons.', 'heroicons-solid:', $icon);
}
@endphp

<iconify-icon
        icon="{{ $icon }}"
        style="{{$color}} font-size: {{$size * 3.4}}px;"
        class="{{$class}}"
>
</iconify-icon>

