@props([
    'icon' => '',
    'size' => 5,
    'color' => '',
    'class' => $attributes->get('class')
])

@if($icon && View::exist("moonshine::ui.icons.$icon"))
    @includeWhen(View::exist("moonshine::ui.icons.{$icon}"), "moonshine::ui.icons.$icon", array_merge([
        'size' => $size,
        'class' => $class,
        'color' => $color
    ]))
@elseif ($icon)
    @php
        /** @var int $iconSizeMultiplier */
        $iconSizeMultiplier = config('moonshine-iconify.icon_size_multiplier', 1);
    @endphp

    <iconify-icon icon="{{$icon}}"
                  style="color: {{$color}};font-size: {{$size * $iconSizeMultiplier}}"
                  class="{{$class}}"
    >
    </iconify-icon>
@endif




