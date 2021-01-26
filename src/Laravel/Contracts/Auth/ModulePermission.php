<?php


namespace Goodcatch\Modules\Laravel\Contracts\Auth;


use Closure;

interface ModulePermission
{

    /**
     * Register a provider creator Closure.
     *
     * @param  string  unique name
     * @param  closure  callback that initiat provider
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function permission ($alias, Closure $callback);

    /**
     * @param $alias
     * @return \Goodcatch\Modules\Laravel\Contracts\Auth\PermissionProvider
     */
    public function getProvider ($alias);
}