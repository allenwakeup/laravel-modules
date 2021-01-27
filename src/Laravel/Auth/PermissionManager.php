<?php


namespace Goodcatch\Modules\Laravel\Auth;

use Closure;
use Goodcatch\Modules\Laravel\Contracts\Auth\ModulePermission;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class PermissionManager implements ModulePermission
{
    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * this config /config/config.php.
     *
     * @var array
     */
    protected $config;

    /**
     * The registered custom provider creators.
     *
     * @var array
     */
    protected $providerCreators = [];


    /**
     * Create a new Auth manager instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct ($app)
    {
        $this->app = $app;
        $this->config = $this->app ['config'];
    }

    /**
     * @inheritDoc
     */
    public function permission ($alias, Closure $callback)
    {
        if (! isset ($this->providerCreators [$alias ?? null])) {
            $this->providerCreators [$alias] = call_user_func (
                $callback, $this->app
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function getProvider ($alias)
    {
        if (isset ($this->providerCreators [$alias ?? null])) {
            return $this->providerCreators [$alias];
        }
        return $this->getDefaultProvider ();
    }

    /**
     * Get the guard configuration.
     *
     * @param  string  $name
     * @return array
     */
    protected function getConfig ($name, $default = null)
    {
        return Arr::get ($this->config, "modules.service.permission.{$name}", $default);
    }

    /**
     * Initiate default PermissionProvider
     *
     * @param string $name
     * @return \Goodcatch\Modules\Laravel\Contracts\Auth\PermissionProvider
     */
    protected function getDefaultProvider ()
    {
        $alias = $this->getProviderAlias ();
        $this->permission (
            $alias,
            function ($app) use ($alias) {
                $class = 'Goodcatch\\Modules\\' . Str::ucfirst ($alias) . '\\Contracts\\Permission\\PermissionProvider';
                return new $class ($app, $alias);
            }
        );
        return $this->providerCreators [$alias];
    }

    /**
     * Get configuration name of PermissionProvider
     *
     * @param string $name
     * @return \Goodcatch\Modules\Laravel\Contracts\Auth\PermissionProvider
     */
    protected function getProviderAlias ()
    {
        $driver_name = $this->getConfig ('driver');
        return $alias = Str::lower ($this->getConfig ("providers.{$driver_name}"));
    }


    /**
     * Dynamically call the default provider instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call ($method, $parameters)
    {
        return $this->getProvider ($method);
    }

}