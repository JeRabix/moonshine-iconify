<?php

namespace JeRabix\MoonshineIconify\Detectors;

use MoonShine\UI\Components\Icon;

class IconComponentDetector extends BaseStaticMakeMethodDetector
{
   protected ?string $classDetector = Icon::class;

   protected int $propertyPosition = 0;
}
