<?php

namespace Goodcatch\Modules\Commands;

use Nwidart\Modules\Commands\MigrateCommand as Command;
use Nwidart\Modules\Module;

class MigrateCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'goodcatch:migrate';

    /**
     * Run the migration from the specified module.
     *
     * @param Module $module
     */
    protected function migrate(Module $module)
    {
        parent::migrate($module);

        if ($this->option('seed')) {
            $this->call('module:seed', ['module' => $module->getName(), '--force' => $this->option('force')]);
        }
    }
}
