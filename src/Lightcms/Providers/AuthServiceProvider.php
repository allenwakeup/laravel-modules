<?php


namespace Goodcatch\Modules\Lightcms\Providers;

use \Goodcatch\Modules\Laravel\Providers\AbsAuthServiceProvider as ServiceProvider;
use Goodcatch\Modules\Lightcms\Model\Admin\AdminUser;
use Illuminate\Support\Arr;

class AuthServiceProvider extends ServiceProvider
{

    /**
     * @inheritDoc
     */
    function loadAuthConfig ()
    {
        $guard_name = 'admin';

        $config = $this->readConfig ('guards');

        if (Arr::get ($config, $guard_name . '.provider', 'admin_users') === 'admin_users') {
            $provider = 'laravel-modules';

            Arr::set ($config, $guard_name . '.provider', $provider);

            $this->writeConfig ('guards', $config);

            $this->checkAuthConfig ('providers', $provider, [
                'driver' => 'eloquent',
                'model'  => AdminUser::class
            ]);
        }
    }
}