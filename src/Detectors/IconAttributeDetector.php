<?php

namespace JeRabix\MoonshineIconify\Detectors;


use ReflectionClass;
use MoonShine\Attributes\Icon;
use PhpParser\Node\Stmt\Class_;
use App\MoonShine\Resources\MoonShineUserRoleResource;

class IconAttributeDetector extends AbstractDetector
{
    /**
     * @inheritdoc
     */
    public function detect(array $stmt): array
    {
        // ->icon() method
        $this->nodeFinder->find($stmt, function ($node) {
            if (
                $node instanceof Class_ &&
                $node->namespacedName->toString() === MoonShineUserRoleResource::class
            ) {
                $ref = new ReflectionClass($node->namespacedName->toString());

                dd($ref->getAttributes(Icon::class));
            }

            return false;
        });

        return $this->findIcons;
    }
}
