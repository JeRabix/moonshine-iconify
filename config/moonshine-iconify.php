<?php

use JeRabix\MoonshineIconify\Enums\WorkingMode;
use JeRabix\MoonshineIconify\Detectors\DetectorContract;
use JeRabix\MoonshineIconify\Detectors\AbstractDetector;
use JeRabix\MoonshineIconify\Detectors\MenuItemDetector;
use JeRabix\MoonshineIconify\Commands\DownloadIconifyIconsCommand;

return [
    /**
     * Check enum value comments
     *
     * @see WorkingMode::ICONIFY_COMPONENT_MODE
     * @see WorkingMode::DOWNLOAD_USAGE_ICONS_MODE
     */
    'working_mode' => WorkingMode::ICONIFY_COMPONENT_MODE,

    /**
     * When NULL - load iconify from CDN.
     *
     * working only with:
     * @see WorkingMode::ICONIFY_COMPONENT_MODE
     */
    'iconify_script_url' => null,


    /**
     * Size for moonshine icons multiplied by this multiplier
     *
     * working only with:
     * @see WorkingMode::ICONIFY_COMPONENT_MODE
     */
    'icon_size_multiplier' => 3.2,

    /**
     * Additional detectors for moonshine icons
     *
     * When you have own classes with using icons, you need to create detectors for classes
     * and define they here
     *
     * working only with:
     * @see WorkingMode::DOWNLOAD_USAGE_ICONS_MODE
     *
     * @see DetectorContract
     * @see AbstractDetector
     * @see MenuItemDetector
     */
    'additional_detectors' => [],

    /**
     * Delete not used icons in download command?
     * @see DownloadIconifyIconsCommand
     *
     * working only with:
     * @see WorkingMode::DOWNLOAD_USAGE_ICONS_MODE
     */
    'delete_not_used_icons' => true,

    /**
     * Path to detect icons usage
     *
     * @see DownloadIconifyIconsCommand
     *
     * working only with:
     * @see WorkingMode::DOWNLOAD_USAGE_ICONS_MODE
     */
    'detect_icons_path' => app_path(),

];
