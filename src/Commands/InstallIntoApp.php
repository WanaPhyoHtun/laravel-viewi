<?php

namespace ProtoneMedia\LaravelViewi\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Finder\SplFileInfo;
use Viewi\PageEngine;

class InstallIntoApp extends Command
{
    public $signature = 'viewi:install';

    public $description = 'Install Viewi';

    public function handle(): int
    {
        $this->installComponents();
        $this->installRoutes();

        return self::SUCCESS;
    }

    private function installRoutes()
    {
        $webRoutes = file_get_contents($webRoutesPath = base_path('routes/web.php'));

        if (!Str::contains($webRoutes, $facade = 'use Illuminate\\Support\\Facades\\Route;')) {
            $webRoutes = str_replace('<?php', '<?php' . PHP_EOL . PHP_EOL . $facade, $webRoutes);
        }

        if (!Str::contains($webRoutes, $views = 'use App\\Components\\Views;')) {
            $webRoutes = str_replace('<?php', '<?php' . PHP_EOL . PHP_EOL . $views, $webRoutes);
        }

        $webRoutes .= PHP_EOL . implode(PHP_EOL, [
            'Route::get(\'/\', Views\\Home\\HomePage::class);',
            'Route::get(\'/counter\', Views\\Pages\\CounterPage::class);',
            'Route::get(\'/todo\', Views\\Pages\\TodoAppPage::class);',
            'Route::get(\'*\', Views\\NotFound\\NotFoundPage::class);',
        ]);

        file_put_contents($webRoutesPath, $webRoutes);

        $this->info("Installed example routes!");
    }

    private function installComponents()
    {
        $sourceDir = config('viewi.' . PageEngine::SOURCE_DIR);

        (new Filesystem)->copyDirectory(
            base_path('vendor/viewi/viewi/stubs/new-app/Components'),
            $sourceDir
        );

        $files = (new Filesystem)->allFiles($sourceDir);

        $namespace = config('viewi.components_namespace');

        foreach ($files as $file) {
            /** @var SplFileInfo $file */
            if ($file->getExtension() !== 'php') {
                continue;
            }

            $newContents = str_replace(
                ['namespace Components\\', 'use Components\\'],
                ['namespace ' . $namespace, 'use ' . $namespace],
                $file->getContents()
            );

            file_put_contents($file->getRealPath(), $newContents);
        }

        $this->info("Installed example components!");
    }
}
