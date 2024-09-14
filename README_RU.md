## Moonshine-Iconify - интегрируйте библиотеку [Iconify](https://iconify.design/) для панели администратора [Moonshine](https://github.com/moonshine-software/moonshine)

![logo](https://github.com/JeRabix/moonshine-iconify/raw/master/art/logo-new.png)

<p align="center">
<b>
<a href="https://github.com/JeRabix/moonshine-iconify">EN</a> |
<a href="https://github.com/JeRabix/moonshine-iconify/blob/master/README_RU.md">RU</a>
</b>
</p>

## Установка

Установить пакет composer

```bash
composer require jerabix/moonshine-iconify
```

Опубликовать файл `icon.blade.php` из пакета:

```bash
php artisan vendor:publish --tag="moonshine-iconify-blade"
```

Эта команда помещает файл `icon.blade.php` в папку `resources/views/vendor/moonshine/components`.

(Необязательно) Вы также можете опубликовать файл конфигурации из пакета:

```bash
php artisan vendor:publish --tag="moonshine-iconify-config"
```

## Использование

При использовании `ICONIFY_COMPONENT_MODE` - вам не нужны дополнительные действия.

При использовании `DOWNLOAD_USAGE_ICONS_MODE` - вам нужно выполнить команду: `php artisan moonshine-iconify:icons:download` для загрузки всех иконок используемых в проекте.

Используйте компонент Moonshine по умолчанию `Icon`, как и раньше.
Пакет работает как запасной вариант, если иконка не найдена в Moonshine - используйте библиотеку iconify.

Иконки Iconify можно найти [здесь](https://icon-sets.iconify.design/).

## Режим работы

Пакет имеет 2 режима работы:

### ICONIFY_COMPONENT_MODE [iconify doc](https://iconify.design/docs/icon-components/#process)

Используется компонент iconify. Загружает иконки из API iconify по необходимости и кэширует в localstorage пользователя, необходимо загружать JS скрипт iconify (пакет добавляет его автоматически).

### DOWNLOAD_USAGE_ICONS_MODE

Используйте команду пакета для загрузки используемых иконок iconify в проект. Необходимо повторно запустить команду для каждой новой иконки iconify в проекте.

## Конфигурация

| **Ключ**              | **Описание**                                                                                                                                                                               | **Значение по умолчанию**           |
|-----------------------|--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|-------------------------------------|
| working_mode          | Режим рабочего пакета, может быть WorkingMode::ICONIFY_COMPONENT_MODE или WorkingMode::DOWNLOAD_USAGE_ICONS_MODE, для получения дополнительной информации см. описание перечисления        | WorkingMode::ICONIFY_COMPONENT_MODE |
| iconify_script_url    | (Только для ICONIFY_COMPONENT_MODE) URL для загрузки скрипта iconify. По умолчанию используется ссылка CDN с официального сайта.                                                           | NULL                                |
| icon_size_multiplier  | (Только для ICONIFY_COMPONENT_MODE) Иконки Moonshine и iconify имеют разные размеры. Поэтому требуется какой-то множитель, чтобы иконки moonshine и iconify не отличались по размеру       | 3.2                                 |
| additional_detectors  | (Только для DOWNLOAD_USAGE_ICONS_MODE) Дополнительные детекторы для иконок moonshine. Если у вас есть собственные классы с использованием иконок, вам нужно создать детекторы для классов. | []                                  |
| delete_not_used_icons | (Только для DOWNLOAD_USAGE_ICONS_MODE) Удалить неиспользуемые иконки в команде загрузки?                                                                                                   | true                                |
| detect_icons_path     | (Только для DOWNLOAD_USAGE_ICONS_MODE) Путь для обнаружения использования иконок                                                                                                           | app_path()                          |

## Детектор N имеет ошибку: X

Когда у вас есть ошибка: `Detector {DetectorClass} has error: {Error}. Details in log file`

Создайте issue [тут](https://github.com/JeRabix/moonshine-iconify/issues/new). И предоставьте информацию из файла логов.

## Иконка не загружается командой

Если у вас есть собственный класс с использованием иконки, вам нужно создать детектор для класса. Посмотрите для примера класс IconComponentDetector.

Если класс предоставляется из Moonshine - вы можете создать issue [тут](https://github.com/JeRabix/moonshine-iconify/issues/new).
