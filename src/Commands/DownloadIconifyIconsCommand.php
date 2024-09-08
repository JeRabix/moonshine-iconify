<?php

namespace JeRabix\MoonshineIconify\Commands;

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

class DownloadIconifyIconsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'moonshine-iconify:icons:download';

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

    public function handle(): void
    {
        $this->scanSources(app_path());

        $this->findUsedIcons();

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

            $iconContent = file_get_contents($apiUrl);

            file_put_contents("$path/$iconName.blade.php", $iconContent);
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
        }

        $icons = array_unique($icons);

        $icons = array_filter($icons, function (string $icon) {
            return explode(':', $icon)[1] ?? false;
        });

        $icons = array_values($icons);

        $this->foundIcons = $icons;
    }
}
