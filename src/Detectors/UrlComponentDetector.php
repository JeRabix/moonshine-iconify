<?php

namespace JeRabix\MoonshineIconify\Detectors;

use MoonShine\UI\Components\Url;

class UrlComponentDetector extends BaseStaticMakeMethodDetector
{
    protected ?string $classDetector = Url::class;
}
