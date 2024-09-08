<?php

namespace JeRabix\MoonshineIconify\Detectors;

use PhpParser\Node\Stmt;

interface DetectorContract
{
    /**
     * @param Stmt[] $stmt
     *
     * @return string[]
     */
    public function findIcons(array $stmt): array;
}
