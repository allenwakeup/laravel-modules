<?php

namespace Goodcatch\Modules\Laravel\Jobs;

use Goodcatch\Modules\Laravel\Repository\ModuleRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Cache;

class RefreshDatabaseModules implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    /**
     * Fresh cached modules
     *
     * @return void
     */
    public function handle ()
    {
        if (module_config ('cache.enabled', false))
        {
            $cache_key = module_config ('cache.key', 'laravel-modules');

            Cache::forget ($cache_key);

            Cache::remember ($cache_key,  module_config ("cache.lifetime", 60), function () {

                return ModuleRepository::all ();
            });
        }

    }
}
