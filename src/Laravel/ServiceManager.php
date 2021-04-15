<?php


namespace Goodcatch\Modules\Laravel;

use Closure;
use Goodcatch\Modules\Laravel\Contracts\Auth\PermissionProvider;
use Goodcatch\Modules\Laravel\Contracts\ModuleService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Arr;
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
     * @param  array $config
     */
    public function __construct ($app, $config)
    {
        $this->app = $app;
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function register ($driver, Closure $callback)
    {
        if (! isset ($this->providerCreators [$driver ?? null])) {
            $this->providerCreators [$driver] = call_user_func (
                $callback, $this->app
            );
        }
    }

    /**
     * @inheritDoc
     */
    public function getProvider ($driver)
    {
        if (isset ($driver) && isset ($this->providerCreators [$driver])) {
            return $this->providerCreators [$driver];
        }
        return $this->getDefaultProvider ();
    }

    /**
     * Get the guard configuration.
     *
     * @param  string  $name
     * @param  string  $default
     * @return string|mixed
     */
    abstract public function getConfig ($name, $default = null);


    /**
     * Create a default service
     *
     * @param $driver
     * @return mixed
     */
    abstract public function createService ($driver);

    /**
     * Initiate default PermissionProvider
     *
     * @return PermissionProvider
     */
    protected function getDefaultProvider ()
    {
        $driver = $this->getProviderDriver ();
        $this->register (
            $driver,
            function () use ($driver) {
                return $this->createService ($driver);
            }
        );
        return $this->providerCreators [$driver];
    }

    /**
     * Get configuration name of Service driver
     *
     * @return string|mixed
     */
    protected function getProviderDriver ()
    {
        return $this->getConfig ('driver');
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