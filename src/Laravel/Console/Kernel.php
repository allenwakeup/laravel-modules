<?php

namespace Goodcatch\Modules\Laravel\Console;

use App\Console\Kernel as ConsoleKernel;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Contracts\Container\BindingResolutionException;
use RuntimeException;

class Kernel extends ConsoleKernel
{

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule (Schedule $schedule)
    {
        parent::schedule ($schedule);

        $this->modulesSchedule ($schedule);
    }

    /**
     * Define the module's command schedule.
     *
     * @param Schedule $schedule
     */
    private function modulesSchedule (Schedule $schedule)
    {
        $modules = app ('modules') ? app ('modules')->allEnabled () : [];
        foreach ($modules as $module_name => $module)
        {
            if ($this->app->bound ('console.' . $module->getLowerName ())) {
                try {
                    $this->app->make('console.' . $module->getLowerName(), compact('schedule'))->schedule();
                } catch (BindingResolutionException $e) {
                    throw new RuntimeException(
                        'Unable to resolve the dispatcher from the service container. Please bind it or install illuminate/bus.',
                        $e->getCode(), $e
                    );
                }
            }
        }
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {

        parent::commands ();

        $this->load (__DIR__.'/Commands');

        // 搜寻模块下的命令
        $modules = app ('modules') ? app('modules')->all () : [];
        foreach ($modules as $module_name => $module) {
            if ($module->isEnabled ()) {
                $this->load (module_generated_path($module->getLowerName (), 'command'));
            }
        }

    }
}
