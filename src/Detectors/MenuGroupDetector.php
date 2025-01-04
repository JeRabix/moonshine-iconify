<?php

namespace JeRabix\MoonshineIconify\Detectors;

use MoonShine\MenuManager\MenuGroup;

class MenuGroupDetector extends BaseStaticMakeMethodDetector
{
   protected ?string $classDetector = MenuGroup::class;
}
