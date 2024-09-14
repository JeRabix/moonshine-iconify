<?php

namespace JeRabix\MoonshineIconify\Ignition\BeforeIgnitionRefactor;

use Illuminate\Support\Facades\Artisan;
use JeRabix\MoonshineIconify\Commands\DownloadIconifyIconsCommand;
use Spatie\Ignition\Contracts\RunnableSolution;


class IconNotFoundSolution implements RunnableSolution
{

    public function getSolutionActionDescription(): string
    {
        return 'Run command: php artisan moonshine-iconify:icons:download';
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
