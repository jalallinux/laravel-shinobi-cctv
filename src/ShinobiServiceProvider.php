<?php

namespace JalalLinuX\Shinobi;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use JalalLinuX\Shinobi\Commands\ShinobiCommand;
use \JalalLinuX\Shinobi\Facades\Shinobi as ShinobiFacade;

class ShinobiServiceProvider extends PackageServiceProvider
{
    public function registeringPackage()
    {
        $this->app->singleton(ShinobiFacade::class, Shinobi::class);
    }

    public function configurePackage(Package $package): void
    {
        $package
            ->name('shinobi-cctv')
            ->hasConfigFile('shinobi')
            ->hasViews()
            ->hasCommand(ShinobiCommand::class);
    }
}
