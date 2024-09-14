<?php

namespace JeRabix\MoonshineIconify\Ignition;

use Illuminate\Support\Arr;
use Spatie\ErrorSolutions\Contracts\HasSolutionsForThrowable;
use Spatie\LaravelIgnition\Exceptions\ViewException;
use Throwable;

class IconNotFoundSolutionProvider implements HasSolutionsForThrowable
{

    public function canSolve(Throwable $throwable): bool
    {
        if (!$throwable instanceof ViewException) {
            return false;
        }

        $viewPath = Arr::get($throwable->context(), 'view.view');

        if (!$viewPath || $viewPath !== resource_path('views/vendor/moonshine/components/icon.blade.php')) {
            return false;
        }

        return true;
    }

    public function getSolutions(Throwable $throwable): array
    {
        return [
            new IconNotFoundSolution()
        ];
    }
}
