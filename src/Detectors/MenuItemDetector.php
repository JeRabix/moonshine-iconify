<?php

namespace JeRabix\MoonshineIconify\Detectors;

use MoonShine\Menu\MenuItem;

class MenuItemDetector extends BaseStaticMakeMethodDetector
{
    /**
     * @var class-string $classDetector
     */
    protected ?string $classDetector = MenuItem::class;
}
