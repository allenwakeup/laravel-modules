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
     * get a service
     *
     * @param  $alias  provider alias
     * @return  mixed|null
     */
    public function getProvider ($alias);
}