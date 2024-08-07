<?php

declare(strict_types=1);

namespace JeRabix\MoonshineIconify\Providers;

use Illuminate\Support\ServiceProvider;

final class MoonshineIconifyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        moonshineAssets()->add([
            'https://cdn.jsdelivr.net/npm/iconify-icon@2.1.0/dist/iconify-icon.min.js',
            '/vendor/moonshine-iconify/css/index.css',
        ]);

        $this->publishes([
            __DIR__ . '/../../resources/views/icon.blade.php' => resource_path('views/vendor/moonshine/components/icon.blade.php'),
        ]);

        $this->publishes([
            __DIR__ . '/../../public' => public_path('vendor/moonshine-iconify'),
        ], ['moonshine-iconify-assets', 'laravel-assets']);
    }
}
