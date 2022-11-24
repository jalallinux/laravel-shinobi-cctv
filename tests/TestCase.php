<?php

namespace JalalLinuX\Shinobi\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use JalalLinuX\Shinobi\ShinobiServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'JalalLinuX\\Shinobi\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            ShinobiServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-shinobi-cctv_table.php.stub';
        $migration->up();
        */
    }
}
