<?php

namespace Mrfansi\LaravelCloudflareSdk;

use Mrfansi\LaravelCloudflareSdk\Commands\LaravelCloudflareSdkCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelCloudflareSdkServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-cloudflare-sdk')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel_cloudflare_sdk_table')
            ->hasCommand(LaravelCloudflareSdkCommand::class);
    }
}
