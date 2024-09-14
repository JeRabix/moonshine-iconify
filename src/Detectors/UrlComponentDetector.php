<?php

namespace JeRabix\MoonshineIconify\Detectors;

use MoonShine\Components\Url;

class UrlComponentDetector extends BaseStaticMakeMethodDetector
{
    protected ?string $classDetector = Url::class;
}
