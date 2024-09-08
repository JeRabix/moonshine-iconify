<?php

namespace JeRabix\MoonshineIconify\Detectors;


use ReflectionAttribute;
use ReflectionClass;
use MoonShine\Attributes\Icon;
use PhpParser\Node\Stmt\Class_;

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
                $node instanceof Class_
            ) {
                $ref = new ReflectionClass($node->namespacedName->toString());

                /** @var ?ReflectionAttribute $targetAttribute */
                $targetAttribute = $ref->getAttributes(Icon::class)[0] ?? null;

                if (!$targetAttribute) {
                    return false;
                }

                $iconName = $targetAttribute->getArguments()[0] ?? null;

                if ($iconName) {
                    $this->findIcons[] = $iconName;
                }

                return false;
            }

            return false;
        });

        return $this->findIcons;
    }
}
