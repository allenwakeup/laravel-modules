<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Providers;


use Goodcatch\Modules\Commands\MigrateCommand;
use Goodcatch\Modules\Commands\MigrateRefreshCommand;
use Goodcatch\Modules\Commands\SeedCommand;
use Goodcatch\Modules\Laravel\Console\Commands\CacheCommand;
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
        TableCommand::class,
        CacheCommand::class,
        SeedCommand::class,
        MigrateCommand::class,
        MigrateRefreshCommand::class
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
