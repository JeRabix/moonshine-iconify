<?php

namespace JeRabix\MoonshineIconify\Commands;

use Throwable;
use JeRabix\MoonshineIconify\Detectors\DetectorContract;
use JeRabix\MoonshineIconify\IconLoaders\Iconify\IconifyIconLoader;
use Illuminate\Console\Command;

class DownloadIconifyIconsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moonshine-iconify:icons:download
        {--force : Force download icons}
    ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download all uses in project icons';

    public function handle(): void
    {
        $isForce = boolval($this->option('force'));
        $scanPath = config('moonshine-iconify.detect_icons_path', app_path());
        $isDeleteNotUsedIcons = config('moonshine-iconify.delete_not_used_icons', true);
        /**
         * @var class-string<DetectorContract>[] $additionalDetectors
         */
        $additionalDetectors = config('moonshine-iconify.additional_detectors', []);

        $loader = new IconifyIconLoader(
            $scanPath,
            $isForce,
            $isDeleteNotUsedIcons,
            $additionalDetectors,
            function (string $detectorClass, Throwable $throwable) {
                $this->info("Detector $detectorClass has error: {$throwable->getMessage()}. Details in log file.");
            }
        );

        $loader->run();

        $this->info('Icons downloaded successfully.');
    }

}
