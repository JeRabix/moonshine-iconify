@props([
    'icon' => '',
    'size' => 5,
    'color' => '',
    'class' => $attributes->get('class')
])

@if($icon && View::exists("moonshine::ui.icons.$icon"))
    @include("moonshine::ui.icons.$icon", array_merge([
        'size' => $size,
        'class' => $class,
        'color' => $color
    ]))
@elseif ($icon)
    @php
        /** @var int $iconSizeMultiplier */
        $iconSizeMultiplier = config('moonshine-iconify.icon_size_multiplier', 3.2);
    @endphp

    <iconify-icon icon="{{$icon}}"
                  style="color: {{$color}};font-size: {{$size * $iconSizeMultiplier}}px"
                  class="{{$class}}"
    >
    </iconify-icon>
@endif




