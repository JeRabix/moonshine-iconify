<?php

namespace JeRabix\MoonshineIconify\Enums;

use JeRabix\MoonshineIconify\Commands\DownloadIconifyIconsCommand;

enum WorkingMode: string
{
    /**
     * Load icons from iconify API on demand, and cache to user localstorage
     *
     * need load iconify JS script
     *
     * @see https://iconify.design/docs/icon-components/#process
     */
    case ICONIFY_COMPONENT_MODE = 'iconify_component_mode';

    /**
     * Use package command for download used iconify icons to project
     *
     * need re-run command for each new iconify icon in project
     *
     * @see DownloadIconifyIconsCommand
     */
    case DOWNLOAD_USAGE_ICONS_MODE = 'download_usage_icons_mode';
}
