<?php

namespace Goodcatch\Modules\Laravel\Providers;

use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

abstract class AbsAuthServiceProvider extends ServiceProvider
{


    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot ()
    {
        $this->loadAuthConfig ();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register ()
    {

    }

    /**
     * get app config
     *
     * @return \Illuminate\Config\Repository
     */
    protected function getConfig ()
    {
        return $this->app ['config'];
    }

    /**
     * get the app config for auth
     *
     * @param $name
     * @return array|mixed
     */
    protected function readConfig ($name)
    {
        return $this->getConfig ()->get ('auth.' . $name);
    }

    /**
     * update the app config for auth
     *
     * @param $name
     * @param $values
     */
    protected function writeConfig ($name, $values)
    {
        $this->getConfig ()->set ('auth.' . $name, $values);
    }

    /**
     * checkout config if doesn't exist and then set default value
     *
     * @param $name  string  config key name
     * @param $check  string  config key name to be checked
     * @param $values  mixed  config values to be set
     */
    protected function checkAuthConfig ($name, $check, $values) {
        $config = $this->readConfig ($name);

        if (! Arr::has ($config, $check))
        {
            Arr::set ($config, $check, $values);

            $this->writeConfig ($name, $config);
        }
    }

    /**
     * make sure required configuration has been set
     */
    abstract function loadAuthConfig ();
}
