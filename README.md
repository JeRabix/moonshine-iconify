## Moonshine-Iconify - integrate [Iconify](https://iconify.design/) library for [Moonshine](https://github.com/moonshine-software/moonshine) admin panel

![logo](https://github.com/JeRabix/moonshine-iconify/raw/master/art/logo-new.png)

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
