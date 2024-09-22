## Moonshine-Iconify - integrate [Iconify](https://iconify.design/) library for [Moonshine](https://github.com/moonshine-software/moonshine) admin panel

![logo](https://github.com/JeRabix/moonshine-iconify/raw/master/art/logo-new.png)

<p align="center">
<b>
    <a href="https://github.com/JeRabix/moonshine-iconify">EN</a> |
    <a href="https://github.com/JeRabix/moonshine-iconify/blob/master/README_RU.md">RU</a>
</b>
</p>

## Installation

Install composer package

```bash
composer require jerabix/moonshine-iconify
```

Publish `icon.blade.php` file from package:

```bash
php artisan vendor:publish --tag="moonshine-iconify-blade"
```

This command put file `icon.blade.php` in `resources/views/vendor/moonshine/components` folder.

(Optional) You can also publish config file from package:

```bash
php artisan vendor:publish --tag="moonshine-iconify-config"
```

## Usage

When you use `ICONIFY_COMPONENT_MODE` - you not need additional actions.

When you use `DOWNLOAD_USAGE_ICONS_MODE` - you need run command:
```bash
php artisan moonshine-iconify:icons:download
```
for download all usage icons in project.

Use moonshine default `Icon` component as before.
Package work as fallback if icon is not found in moonshine - use iconify library.

Iconify icons can be found [here](https://icon-sets.iconify.design/).

## Working mode

Package has 2 working mode:

### ICONIFY_COMPONENT_MODE [iconify doc](https://iconify.design/docs/icon-components/#process)

Used iconify component. Load icons from iconify API on demand, and cache to user localstorage, need load iconify JS script (package add it automatically).

### DOWNLOAD_USAGE_ICONS_MODE

Use package command for download used iconify icons to project. Need re-run command for each new iconify icon in project.

## Config

| **Key**               | **Description**                                                                                                                                                                                               | **Default value**                   |
|-----------------------|---------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------------------------|
| working_mode          | Working package mode, can be WorkingMode::ICONIFY_COMPONENT_MODE or WorkingMode::DOWNLOAD_USAGE_ICONS_MODE, check enum description for more information                                                       | WorkingMode::ICONIFY_COMPONENT_MODE |
| iconify_script_url    | (Only for ICONIFY_COMPONENT_MODE) URL for load iconify script. By default use CDN link from official website.                                                                                                 | NULL                                |
| icon_size_multiplier  | (Only for ICONIFY_COMPONENT_MODE) Moonshine icons and iconify icons has different size measurements. Therefore, some kind of multiplier is required so that moonshine icons and iconify do not differ in size | 3.2                                 |
| additional_detectors  | (Only for DOWNLOAD_USAGE_ICONS_MODE) Additional detectors for moonshine icons. When you have own classes with using icons, you need to create detectors for classes.                                          | []                                  |
| delete_not_used_icons | (Only for DOWNLOAD_USAGE_ICONS_MODE) Delete not used icons in download command?                                                                                                                               | true                                |
| detect_icons_path     | (Only for DOWNLOAD_USAGE_ICONS_MODE) Path to detect icons usage                                                                                                                                               | app_path()                          |

## Detector N has error: X

When you has error: `Detector {DetectorClass} has error: {Error}. Details in log file`

Create issue [here](https://github.com/JeRabix/moonshine-iconify/issues/new). And provide info from log file.

## Icon not download with command

When you has own class with using icon, you need to create detector for class. Check IconComponentDetector class.

When class provide from Moonshine - you can create issue [here](https://github.com/JeRabix/moonshine-iconify/issues/new).

## TODO

 - [x] [Local icons mode] Detect `WithIcon` trait on classes
 - [x] [Local icons mode] Detect `Url` class
 - [x] [Local icons mode] Add `Icon` class detector
 - [x] [Local icons mode] Detect `Icon` attribute usage
 - [x] [Local icons mode] Remove not used icons
 - [x] [Local icons mode] Not download all icons every run command, only new
 - [x] [Local icons mode] Add `mode` to config to change dynamic/static icons mode
 - [x] Add button to ignition error page
 - [x] Refactor detect logic
 - [x] Update README file for new working mode
 - [ ] Add tests for detect logic
