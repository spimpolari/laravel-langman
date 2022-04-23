<?php

namespace Spimpolari\Langman;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\Filesystem;

class LangmanServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/langman.php' => config_path('langman.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/langman.php', 'langman');

        $this->app->bind(Manager::class, function () {
            return new Manager(
                new Filesystem,
                config('langman.path'),
                array_merge(config('view.paths'), [app_path()])
            );
        });

        $this->commands([
            \Spimpolari\Langman\Commands\MissingCommand::class,
            \Spimpolari\Langman\Commands\RemoveCommand::class,
            \Spimpolari\Langman\Commands\TransCommand::class,
            \Spimpolari\Langman\Commands\ShowCommand::class,
            \Spimpolari\Langman\Commands\FindCommand::class,
            \Spimpolari\Langman\Commands\SyncCommand::class,
            \Spimpolari\Langman\Commands\RenameCommand::class,
        ]);
    }
}
