<?php

namespace Goodcatch\Modules\Laravel\Console\Commands;

use Illuminate\Console\Command;

class CacheCommand extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'goodcatch:cache';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Re-create modules cache';

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function handle ()
    {
        $config = $this->laravel ['config'];

        $cache = $this->laravel ['cache'];

        $activator = $config->get ('modules.activator', 'database');

        $cache_key = $config->get ("modules.activators.$activator.cache-key");

        if (empty ($cache_key))
        {
            $this->info ("no cache key presents, checkout configuration key: modules.activators.$activator.cache-key");

        } else {

            $cache->forget ($cache_key);

            $this->info ('Modules activator cached successfully!');
        }

        if (! $config->get ('modules.cache.enabled', false)) {

            $module_cache_key = $config->get ('modules.cache.key');

            if (empty ($module_cache_key))
            {

                $this->info ("no cache key presents, checkout configuration key: modules.cache.key");

            } else {

                $cache->forget ($module_cache_key);

                $modules = $this->laravel ['modules'];

                $modules->all ();

                $this->info ('Modules cached successfully!');

            }
        }

    }
}
