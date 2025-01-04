@php
    use JeRabix\MoonshineIconify\Enums\WorkingMode;
@endphp

@props([
    'icon' => '',
    'size' => 5,
    'color' => '',
    'class' => $attributes->get('class'),
    'path' => '',
])

@php
    /** @var WorkingMode $iconifyWorkingMode */
    $iconifyWorkingMode = config('moonshine-iconify.working_mode');

    $checkPath = $path ?? 'moonshine::icons';
@endphp


<div {{ $attributes->class([
    'text-current',
    'w-' . ($size ?? 5),
    'h-' . ($size ?? 5),
    "text-$color" => !empty($color),
]) }}>

    @if($slot?->isNotEmpty())
        {!! $slot !!}
    @elseif($icon && View::exists("$checkPath.$icon"))
        @include("moonshine::icons.$icon", array_merge([
            'size' => $size,
            'color' => $color,
            'icon' => $icon,
            'path' => $path,
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
</div>
