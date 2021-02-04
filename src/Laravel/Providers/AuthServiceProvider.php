<?php


namespace Goodcatch\Modules\Laravel\Providers;

use Goodcatch\Modules\Laravel\Model\Admin\User;
use Illuminate\Support\Arr;

class AuthServiceProvider extends AbsAuthServiceProvider
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
                'model'  => User::class
            ]);
        }
    }
}