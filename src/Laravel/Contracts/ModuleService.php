<?php


namespace Goodcatch\Modules\Laravel\Contracts;


use Closure;

interface ModuleService
{


    /**
     * Register a provider creator Closure.
     *
     * @param  string  unique name
     * @param  closure  callback that initiat provider
     */
    public function register ($alias, Closure $callback);

    /**
     * @param $alias
     * @return \Goodcatch\Modules\Laravel\Contracts\Auth\PermissionProvider
     */
    public function getProvider ($alias);
}