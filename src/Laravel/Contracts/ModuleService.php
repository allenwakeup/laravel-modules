<?php


namespace Goodcatch\Modules\Laravel\Contracts;


use Closure;

interface ModuleService
{


    /**
     * Register a provider creator Closure.
     *
     * @param $driver string  unique name
     * @param $callback Closure register new service
     */
    public function register ($driver, Closure $callback);

    /**
     * get a service
     *
     * @param  $driver string service driver
     * @return  mixed|null
     */
    public function getProvider ($driver);
}