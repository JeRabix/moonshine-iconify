<?php

namespace JeRabix\MoonshineIconify\Ignition;

use Illuminate\Support\Facades\Artisan;
use JeRabix\MoonshineIconify\Commands\DownloadIconifyIconsCommand;
use Spatie\ErrorSolutions\Contracts\RunnableSolution;

class IconNotFoundSolution implements RunnableSolution
{

    public function getSolutionActionDescription(): string
    {
        return 'Download usage iconify icons';
    }

    public function getRunButtonText(): string
    {
        return 'Download usage iconify icons';
    }

    public function run(array $parameters = []): void
    {
        Artisan::call(DownloadIconifyIconsCommand::class);
    }

    public function getRunParameters(): array
    {
        return [];
    }

    public function getSolutionTitle(): string
    {
        return 'Icon not found';
    }

    public function getSolutionDescription(): string
    {
        return 'Icon not found';
    }

    public function getDocumentationLinks(): array
    {
        return [];
    }
}
