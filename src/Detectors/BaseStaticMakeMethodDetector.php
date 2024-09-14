<?php

namespace JeRabix\MoonshineIconify\Detectors;

use Exception;
use PhpParser\NodeFinder;
use Illuminate\Support\Arr;
use PhpParser\Node\Expr\StaticCall;

abstract class BaseStaticMakeMethodDetector extends AbstractDetector
{
    /**
     * @var class-string $classDetector
     */
    protected ?string $classDetector = null;

    protected int $propertyPosition = 2;


    public function __construct(
        NodeFinder $nodeFinder,
    )
    {
        parent::__construct($nodeFinder);

        if ($this->classDetector === null) {
            throw new Exception('$classDetector is not set');
        }
    }

    public function findIcons(array $stmt): array
    {
        // static call ::make
        $this->nodeFinder->find($stmt, function ($node) {
            if (
                $node instanceof StaticCall &&
                $node->class->name === $this->classDetector &&
                $node->name->toString() === 'make' &&
                // TODO: а если иконка будет вторым аргументом с помощью именованных аргументов
                Arr::exists($node->args, $this->propertyPosition) &&
                $node->args[$this->propertyPosition]->value
            ) {
                $this->findIcons[] = $node->args[$this->propertyPosition]->value->value;
            }

            return false;
        });

        return $this->findIcons;
    }
}
