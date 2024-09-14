<?php

namespace JeRabix\MoonshineIconify\Detectors;

use PhpParser\NodeAbstract;
use MoonShine\Traits\WithIcon;
use PhpParser\Node\Identifier;
use PhpParser\Node\Scalar\String_;
use PhpParser\Node\Expr\MethodCall;

class WithIconTraitDetector extends AbstractDetector
{
    /**
     * @inheritdoc
     */
    public function findIcons(array $stmt): array
    {
        // ->icon() method
        $this->nodeFinder->find($stmt, function ($node) {
            if (
                $node instanceof MethodCall &&
                $node->name instanceof Identifier &&
                $node->name->toString() === 'icon' &&
                $node->args[0]->value instanceof String_ &&
                $node->args[0]->value->value
            ) {
                $var = $this->detectVar($node->var);

                if (in_array(WithIcon::class, class_uses_recursive($var->class->name))) {
                    $this->findIcons[] = $node->args[0]->value->value;

                    return true;
                }
            }

            return false;
        });

        return $this->findIcons;
    }

    private function detectVar(NodeAbstract $var): NodeAbstract
    {
        if (property_exists($var, 'var')) {
            return $this->detectVar($var->var);
        }

        return $var;
    }
}
