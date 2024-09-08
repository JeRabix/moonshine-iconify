@php
    use JeRabix\MoonshineIconify\Enums\WorkingMode;
@endphp

@props([
    'icon' => '',
    'size' => 5,
    'color' => '',
    'class' => $attributes->get('class')
])

@php
    /** @var WorkingMode $iconifyWorkingMode */
    $iconifyWorkingMode = config('moonshine-iconify.working_mode');
@endphp


@if($icon && View::exists("moonshine::ui.icons.$icon"))
    @include("moonshine::ui.icons.$icon", array_merge([
        'size' => $size,
        'class' => $class,
        'color' => $color
    ]))
@elseif ($iconifyWorkingMode === WorkingMode::DOWNLOAD_USAGE_ICONS_MODE)
    @php
        $iconifyIconParts = explode(':', $icon);

        $iconifyIconName = $iconifyIconParts[1] ?? null;
        $iconifyIconSet = $iconifyIconParts[0] ?? null;
    @endphp

    @include("moonshine::ui.icons.iconify.$iconifyIconSet.$iconifyIconName", array_merge([
        'size' => $size,
        'class' => $class,
        'color' => $color
    ]))
@elseif($iconifyWorkingMode === WorkingMode::ICONIFY_COMPONENT_MODE)
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
