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

Use moonshine default `Icon` component as before.
Package work as fallback if icon is not found in moonshine - use iconify library.

Iconify icons can be found [here](https://icon-sets.iconify.design/).

## Config

| **Key**              | **Description**                                                                                                                                                             | **Default value** |
|----------------------|-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------|
| iconify_script_url   | URL for load iconify script. By default use CDN link from official website.                                                                                                 | NULL              |
| icon_size_multiplier | Moonshine icons and iconify icons has different size measurements. Therefore, some kind of multiplier is required so that moonshine icons and iconify do not differ in size | 3.2               |

## TODO

 - [x] [Local icons mode] Detect `WithIcon` trait on classes
 - [x] [Local icons mode] Detect `Url` class
 - [x] [Local icons mode] Add `Icon` class detector
 - [x] [Local icons mode] Detect `Icon` attribute usage
 - [x] [Local icons mode] Remove not used icons
 - [x] [Local icons mode] Not download all icons every run command, only new
 - [x] [Local icons mode] Add `mode` to config to change dynamic/static icons mode
 - [x] Add button to ignition error page
 - [ ] Refactor detect logic
 - [ ] Add tests for detect logic
