<?php

namespace Goodcatch\Modules\Lightcms\Providers;

use App\Model\Admin\Menu;
use App\Repository\Admin\MenuRepository;
use Goodcatch\Modules\Laravel\Contracts\auth\PermissionProvider;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot ()
    {

    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register ()
    {

        $this->registerMenuService ();
    }

    protected function registerJobs ()
    {
        $this->app->bind ('LightcmsMenuQuery', function ($app, $params) {
            return Menu::query ();
        });

        $this->app->bind ('LightcmsMenuUpdateOrCreate', function ($app, $params) {
            return Menu::updateOrCreate (
                Arr::get ($params, 'attributes'),
                Arr::get ($params, 'values')
            );
        });

        $this->app->bind ('LightcmsRootMenu', function ($app, $params) {
            return MenuRepository::root (Arr::get ($params, 'route'), Arr::get ($params, 'tree'));
        });


    }

    protected function registerMenuService ()
    {
        $this->app->singleton(PermissionProvider::class, function ($app, $params) {

        });
    }

}
