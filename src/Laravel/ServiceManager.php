<?php


namespace Goodcatch\Modules\Laravel;

use Closure;
use Goodcatch\Modules\Laravel\Contracts\Auth\PermissionProvider;
use Goodcatch\Modules\Laravel\Contracts\ModuleService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Traits\ForwardsCalls;

abstract class ServiceManager implements ModuleService
{

    use ForwardsCalls;

    /**
     * The application instance.
     *
     * @var Application
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
     * @param  Application  $app
     * @return void
     */
    public function __construct ($app, $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function register ($alias, Closure $callback)
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
        if (isset ($alias) && isset ($this->providerCreators [$alias])) {
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
    abstract public function getConfig ($name, $default = null);


    /**
     * Create a default service
     *
     * @param $alias
     * @return mixed
     */
    abstract public function createService ($alias);

    /**
     * Initiate default PermissionProvider
     *
     * @return PermissionProvider
     */
    protected function getDefaultProvider ()
    {
        $alias = $this->getProviderAlias ();
        $this->register (
            $alias,
            function ($app) use ($alias) {
                return $this->createService ($alias);
            }
        );
        return $this->providerCreators [$alias];
    }

    /**
     * Get configuration name of PermissionProvider
     *
     * @return PermissionProvider
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
        $provider = $this->getProvider ($method);
        if (! Arr::has ($this->providerCreators, $method)){
            return $this->forwardCallTo ($provider, $method, $parameters);
        }
        return $provider;
    }

}