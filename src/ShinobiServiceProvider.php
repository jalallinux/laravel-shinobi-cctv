<?php

namespace JalalLinuX\Shinobi;

use Illuminate\Support\ServiceProvider;
use JalalLinuX\Shinobi\Facades\Shinobi as ShinobiFacade;

class ShinobiServiceProvider extends ServiceProvider
{
    public function registeringPackage()
    {
        $this->app->singleton(ShinobiFacade::class, Shinobi::class);
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/shinobi.php', 'shinobi');
    }

    public function boot()
    {
        $this->registerCommands();
        $this->registerPublishing();
    }

    protected function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/shinobi.php' => config_path('shinobi.php'),
            ]);
        }
    }

    protected function registerCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\ShinobiCommand::class,
            ]);
        }
    }
}
