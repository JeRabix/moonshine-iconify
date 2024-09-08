<?php

declare(strict_types=1);

namespace JeRabix\MoonshineIconify\Providers;

use Illuminate\Support\ServiceProvider;
use JeRabix\MoonshineIconify\Commands\DownloadIconifyIconsCommand;

final class MoonshineIconifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/moonshine-iconify.php',
            'moonshine-iconify',
        );

        moonshineAssets()->add([
            config('moonshine-iconify.iconify_script_url') ?? 'https://cdn.jsdelivr.net/npm/iconify-icon@2.1.0/dist/iconify-icon.min.js',
        ]);

        $this->publishes([
            __DIR__ . '/../../resources/views/icon.blade.php' => resource_path('views/vendor/moonshine/components/icon.blade.php'),
        ], 'moonshine-iconify-blade');

        $this->publishes([
            __DIR__ . '/../../config/moonshine-iconify.php' => config_path('moonshine-iconify.php'),
        ], 'moonshine-iconify-config');

        $this->commands(
            DownloadIconifyIconsCommand::class
        );
    }
}
