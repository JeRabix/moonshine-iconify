<?php

namespace JeRabix\MoonshineIconify\Detectors;

use MoonShine\Menu\MenuGroup;

class MenuGroupDetector extends BaseStaticMakeMethodDetector
{
   protected ?string $classDetector = MenuGroup::class;
}
