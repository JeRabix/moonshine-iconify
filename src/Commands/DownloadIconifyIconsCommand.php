<?php

namespace JeRabix\MoonshineIconify\Commands;

use Exception;
use Illuminate\Support\Facades\Http;
use JeRabix\MoonshineIconify\Detectors\DetectorContract;
use RegexIterator;
use PhpParser\NodeFinder;
use PhpParser\ParserFactory;
use PhpParser\NodeTraverser;
use RecursiveIteratorIterator;
use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use Illuminate\Support\Facades\File;
use PhpParser\NodeVisitor\NameResolver;
use JeRabix\MoonshineIconify\Detectors\MenuItemDetector;
use JeRabix\MoonshineIconify\Detectors\MenuGroupDetector;
use JeRabix\MoonshineIconify\Detectors\UrlComponentDetector;
use JeRabix\MoonshineIconify\Detectors\WithIconTraitDetector;
use JeRabix\MoonshineIconify\Detectors\IconComponentDetector;
use JeRabix\MoonshineIconify\Detectors\IconAttributeDetector;
use SplFileInfo;

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

    /** @var string[] */
    protected array $analyzeFiles = [];

    /**
     * @var string[]
     */
    protected array $foundIcons = [];

    /** @var string[] */
    protected array $alreadyDownloadedIcons = [];

    /** @var string[] */
    protected array $needDownloadIcons = [];

    public function handle(): void
    {
        $isForce = boolval($this->option('force'));

        $this->scanSources(config('moonshine-iconify.detect_icons_path', app_path()));

        $this->findUsedIcons();

        $this->findCurrentDownloadedIcons();

        if ($isForce) {
            $this->needDownloadIcons = $this->foundIcons;
        } else {
            $this->needDownloadIcons = array_diff(
                $this->foundIcons,
                $this->alreadyDownloadedIcons,
            );
        }

        $this->downloadIcons();

        if (config('moonshine-iconify.delete_not_used_icons', true)) {
            $this->deleteNotUsedIcons();
        }
    }

    protected function scanSources(string $source): void
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source));
        $files = new RegexIterator($files, '/\.php$/');

        foreach ($files as $file) {
            $this->analyzeFiles[] = $file->getPathname();
        }
    }

    private function findUsedIcons(): void
    {
        $parser = (new ParserFactory)->createForNewestSupportedVersion();
        $nodeFinder = new NodeFinder;
        $traverser = new NodeTraverser;

        $traverser->addVisitor(new NameResolver);

        $icons = [];

        foreach ($this->analyzeFiles as $fileWithIcon) {
            $fileCode = $parser->parse(file_get_contents($fileWithIcon));

            $fileCode = $traverser->traverse($fileCode);

            $icons = array_merge(
                $icons,
                (new MenuGroupDetector($nodeFinder))->detect($fileCode),
                (new MenuItemDetector($nodeFinder))->detect($fileCode),
                (new WithIconTraitDetector($nodeFinder))->detect($fileCode),
                (new UrlComponentDetector($nodeFinder))->detect($fileCode),
                (new IconComponentDetector($nodeFinder))->detect($fileCode),
                (new IconAttributeDetector($nodeFinder))->detect($fileCode),
            );

            /**
             * @var class-string<DetectorContract>[] $additionalDetectors
             */
            $additionalDetectors = config('moonshine-iconify.additional_detectors', []);

            foreach ($additionalDetectors as $detector) {
                $icons = array_merge(
                    $icons,
                    (new $detector($nodeFinder))->detect($fileCode),
                );
            }
        }

        $icons = array_unique($icons);

        $icons = array_filter($icons, function (string $icon) {
            return explode(':', $icon)[1] ?? false;
        });

        $icons = array_values($icons);

        $this->foundIcons = $icons;
    }

    private function findCurrentDownloadedIcons(): void
    {
        $source = resource_path('views/vendor/moonshine/ui/icons/iconify');
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($source));
        $files = new RegexIterator($files, '/\.blade\.php$/');

        foreach ($files as $file) {
            /** @var SplFileInfo $file */

            $iconSet = last(explode('/', $file->getPath()));

            if ($iconSet === 'iconify') {
                continue;
            }

            $iconName = explode('.', $file->getFilename())[0] ?? null;

            if (!$iconName || !$iconSet) {
                continue;
            }

            $this->alreadyDownloadedIcons[] = $iconSet . ':' . $iconName;
        }
    }

    private function downloadIcons(): void
    {
        $baseUrl = 'https://api.iconify.design';

        foreach ($this->foundIcons as $icon) {
            $iconData = explode(':', $icon);

            $iconSet = $iconData[0];
            $iconName = $iconData[1];

            $apiUrl = $baseUrl . '/' . $iconSet . '/' . $iconName . '.svg';

            $path = resource_path("views/vendor/moonshine/ui/icons/iconify/$iconSet");

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, recursive: true);
            }

            $iconContent = Http::get($apiUrl)->body();

            if ($iconContent === '404') {
                throw new Exception("Cannot download icon: $icon. By API url: $apiUrl");
            }

            file_put_contents("$path/$iconName.blade.php", $iconContent);
        }
    }

    private function deleteNotUsedIcons(): void
    {
        $notUsedIcons = array_diff($this->alreadyDownloadedIcons, $this->foundIcons);

        $notUsedIconsPaths = array_map(function (string $icon) {
            $iconData = explode(':', $icon);
            $iconSet = $iconData[0];
            $iconName = $iconData[1];

            return resource_path("views/vendor/moonshine/ui/icons/iconify/$iconSet/$iconName.blade.php");
        }, $notUsedIcons);

        foreach ($notUsedIconsPaths as $path) {
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }
}
