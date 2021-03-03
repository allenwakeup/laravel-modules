<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Providers;

use Illuminate\Support\Arr;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{

    protected $config;

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct ($app)
    {
        parent::__construct ($app);

        $this->config = $this->app ['config']->get ('modules', []);


    }


    protected function getModuleConfig ($key, $default)
    {
        return Arr::get($this->config, $key, $default);
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map ()
    {

    }

}
