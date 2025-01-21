<?php

namespace JeRabix\MoonshineIconify\Detectors;

use MoonShine\Components\Alert;

class AlertComponentDetector extends BaseStaticMakeMethodDetector
{
   protected ?string $classDetector = Alert::class;

   protected int $propertyPosition = 0;
}
