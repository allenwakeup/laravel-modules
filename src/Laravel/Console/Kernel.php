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

        if(!empty($this->app['config']->get('app.key'))){
            $this->modulesSchedule ($schedule);
        }
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
                    $module_kernel_extend = $this->app->make('console.' . $module->getLowerName(), [
                        $this,
                        $schedule,
                        $this->events
                    ]);
                    $module_kernel_extend->schedule();
                } catch (BindingResolutionException $e) {
                    throw new RuntimeException(
                        'Unable to resolve the dispatcher from the service container. Please bind it or install illuminate/bus.',
                        $e->getCode(), $e
                    );
                } catch (\Exception $e) {
                    throw new RuntimeException(
                        'Unknown exception',
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

        if(!empty($this->app['config']->get('app.key'))){
            // 搜寻模块下的命令
            $modules = app ('modules') ? app('modules')->all () : [];
            foreach ($modules as $module_name => $module) {
                if ($module->isEnabled ()) {
                    $this->load (module_generated_path($module->getLowerName (), 'command'));
                }
            }
        }
    }
}
