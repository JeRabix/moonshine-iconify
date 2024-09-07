## Moonshine-Iconify - интегрирует [Iconify](https://iconify.design/) библиотеку в [Moonshine](https://github.com/moonshine-software/moonshine) админ панель

![logo](https://github.com/JeRabix/moonshine-iconify/raw/master/art/logo-new.png)

<p align="center">
<b>
    <a href="https://github.com/JeRabix/moonshine-iconify/raw/master/README.md">EN</a> |
    <a href="https://github.com/JeRabix/moonshine-iconify/raw/master/README_RU.md">RU</a>
</b>
</p>

## Установка

Установите composer пакет из командной строки:

```bash
composer require jerabix/moonshine-iconify
```

Опубликуйте файл `icon.blade.php` из пакета:

```bash
php artisan vendor:publish --tag="moonshine-iconify-blade"
```

Эта команда поместит файл `icon.blade.php` в папку `resources/views/vendor/moonshine/components`.

(Опционально) Вы можете также опубликовать файл конфигурации из пакета:

```bash
php artisan vendor:publish --tag="moonshine-iconify-config"
```

## Использование

Используйте moonshine `Icon` компонент как обычно
пакет работает как фоллбэк, если иконка не найдена в moonshine - используется библиотека iconify.

Iconify иконки можно найти [здесь](https://icon-sets.iconify.design/).

## Конфиг

| **Ключ**             | **Описание**                                                                                                                                     | **По умолчанию** |
|----------------------|--------------------------------------------------------------------------------------------------------------------------------------------------|------------------|
| iconify_script_url   | URL для загрузки скрипта iconify. По умолчанию используется ссылка CDN с официального сайта.                                                     | NULL             |
| icon_size_multiplier | Значки Moonshine и iconify имеют разные размеры. Поэтому требуется какой-то множитель, чтобы значки moonshine и iconify не отличались по размеру | 3.2              |
