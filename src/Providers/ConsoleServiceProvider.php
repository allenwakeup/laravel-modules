<?php

namespace Goodcatch\Modules\Providers;


use Goodcatch\Modules\Laravel\Console\Commands\CacheCommand;
use Goodcatch\Modules\Laravel\Console\Commands\CreateModuleRelatedFiles;
use Goodcatch\Modules\Laravel\Console\Commands\TableCommand;
use Illuminate\Support\ServiceProvider;

class ConsoleServiceProvider extends ServiceProvider
{
    /**
     * The available commands
     *
     * @var array
     */
    protected $commands = [
        CreateModuleRelatedFiles::class,
        TableCommand::class,
        CacheCommand::class,
    ];

    /**
     * Register the commands.
     */
    public function register ()
    {
        $this->commands ($this->commands);
    }

    /**
     * @return array
     */
    public function provides ()
    {
        $provides = $this->commands;

        return $provides;
    }
}
