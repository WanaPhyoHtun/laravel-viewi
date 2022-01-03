<?php

namespace ProtoneMedia\LaravelViewi;

use ProtoneMedia\LaravelViewi\Commands\ClearBuildAndPublicAssets;
use ProtoneMedia\LaravelViewi\Commands\InstallIntoApp;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelViewiServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-viewi')
            ->hasConfigFile()
            ->hasCommand(ClearBuildAndPublicAssets::class)
            ->hasCommand(InstallIntoApp::class);
    }
}
