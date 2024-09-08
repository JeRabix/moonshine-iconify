<?php

namespace JeRabix\MoonshineIconify\Detectors;

use PhpParser\NodeFinder;

abstract class AbstractDetector implements DetectorContract
{
    /**
     * @var string[]
     */
    protected array $findIcons = [];

    public function __construct(
        protected NodeFinder $nodeFinder,
    )
    {
    }

}
