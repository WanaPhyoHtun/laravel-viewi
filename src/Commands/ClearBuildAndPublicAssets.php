<?php

namespace ProtoneMedia\LaravelViewi\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Viewi\PageEngine;

class LaravelViewiCommand extends Command
{
    public $signature = 'viewi:clear';

    public $description = 'Clears the build and public assets.';

    public function handle(): int
    {
        (new Filesystem)->deleteDirectory(
            config('laravel-viewi::' . PageEngine::SERVER_BUILD_DIR),
            $preserve = false
        );

        (new Filesystem)->deleteDirectory(
            config('laravel-viewi::' . PageEngine::PUBLIC_BUILD_DIR) . '/viewi-build',
            $preserve = false
        );

        return self::SUCCESS;
    }
}
