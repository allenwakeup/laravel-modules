<?php


namespace Goodcatch\Modules\Laravel\Console\Concerns;

/**
 * 从命令行内核分发计划到模块
 *
 * Interface DispatchSchedule
 * @package Goodcatch\Modules\Laravel\Console\Concerns
 */
interface DispatchSchedule
{

    /**
     * send new schedules
     *
     * @return mixed
     */
    public function schedule ();
}