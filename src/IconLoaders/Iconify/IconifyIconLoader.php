<?php

namespace JeRabix\MoonshineIconify\IconLoaders\Iconify;

use Closure;
use Exception;
use Throwable;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use JeRabix\MoonshineIconify\Detectors\DetectorContract;
use JeRabix\MoonshineIconify\Detectors\IconAttributeDetector;
use JeRabix\MoonshineIconify\Detectors\IconComponentDetector;
use JeRabix\MoonshineIconify\Detectors\MenuGroupDetector;
use JeRabix\MoonshineIconify\Detectors\MenuItemDetector;
use JeRabix\MoonshineIconify\Detectors\UrlComponentDetector;
use JeRabix\MoonshineIconify\Detectors\WithIconTraitDetector;
use PhpParser\NodeFinder;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitor\NameResolver;
use PhpParser\ParserFactory;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RegexIterator;
use SplFileInfo;

class IconifyIconLoader
{
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

    /** @var class-string<DetectorContract>[] */
    protected array $iconDetectors = [];

    /**
     * @param class-string<DetectorContract>[] $additionalDetectors
     */
    public function __construct(
        private readonly string   $scanPath,
        private readonly bool     $isForceLoad = false,
        private readonly bool     $isDeleteNotUsedIcons = true,
        private readonly array    $additionalDetectors = [],
        private readonly ?Closure $detectorThrowCallback = null,
    )
    {
    }

    public function run(): void
    {
        $this->scanSources();

        $this->setDetectors();

        $this->findUsedIcons();

        $this->findCurrentDownloadedIcons();

        if ($this->isForceLoad) {
            $this->needDownloadIcons = $this->foundIcons;
        } else {
            $this->needDownloadIcons = array_diff(
                $this->foundIcons,
                $this->alreadyDownloadedIcons,
            );
        }

        $this->downloadIcons();

        if ($this->isDeleteNotUsedIcons) {
            $this->deleteNotUsedIcons();
        }
    }

    protected function scanSources(): void
    {
        $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->scanPath));
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

        foreach ($this->analyzeFiles as $filePath) {
            $fileCode = $parser->parse(file_get_contents($filePath));

            $fileCode = $traverser->traverse($fileCode);

            foreach ($this->iconDetectors as $detector) {
                try {
                    $icons = array_merge(
                        $icons,
                        (new $detector($nodeFinder))->findIcons($fileCode),
                    );
                } catch (Throwable $throwable) {
                    report($throwable);

                    if ($this->detectorThrowCallback) {
                        ($this->detectorThrowCallback)($detector, $throwable);
                    }
                }
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

    private function setDetectors(): void
    {
        $defaultDetectors = [
            MenuGroupDetector::class,
            MenuItemDetector::class,
            WithIconTraitDetector::class,
            UrlComponentDetector::class,
            IconComponentDetector::class,
            IconAttributeDetector::class,
        ];

        $this->iconDetectors = array_merge(
            $defaultDetectors,
            $this->additionalDetectors,
        );
    }
}
