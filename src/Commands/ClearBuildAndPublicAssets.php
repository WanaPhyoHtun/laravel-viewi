<?php

namespace ProtoneMedia\LaravelViewi\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Viewi\PageEngine;

class ClearBuildAndPublicAssets extends Command
{
    public $signature = 'viewi:clear';

    public $description = 'Clears the build and public assets.';

    public function handle(): int
    {
        (new Filesystem)->deleteDirectory(
            config('viewi.' . PageEngine::SERVER_BUILD_DIR),
            $preserve = false
        );

        (new Filesystem)->deleteDirectory(
            config('viewi.' . PageEngine::PUBLIC_ROOT_DIR) . '/viewi-build',
            $preserve = false
        );

        $this->info("Cleared!");

        return self::SUCCESS;
    }
}
