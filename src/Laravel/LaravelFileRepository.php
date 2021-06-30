<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Laravel;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Nwidart\Modules\FileRepository;
use Nwidart\Modules\Json;
use Nwidart\Modules\Process\Updater;
use Goodcatch\Modules\Process\Installer;
use Symfony\Component\Process\Process;

class LaravelFileRepository extends FileRepository
{

    /**
     * @var $modules array cache
     */
    protected $modules_cache = [];

    /**
     * {@inheritdoc}
     */
    protected function createModule (...$args)
    {
        $key = md5(implode('-', \collect($args)->filter(function($arg) {
            return 'string' === gettype($arg);
        })->values()->all()));
        if(! Arr::has($this->modules_cache, $key)){
            Arr::set($this->modules_cache, $key, new Module (...$args));
        }
        return Arr::get($this->modules_cache, $key);
    }

    /**
     * Update dependencies for the specified module.
     *
     * @param string $module
     */
    public function update ($module)
    {
        with (new Updater ($this))->update ($module);
    }

    /**
     * Install the specified module.
     *
     * @param string $name
     * @param string $version
     * @param string $type
     * @param bool   $subtree
     *
     * @return Process
     */
    public function install ($name, $version = 'dev-master', $type = 'composer', $subtree = false)
    {
        $installer = new Installer ($name, $version, $type, $subtree);

        return $installer->run ();
    }

    /**
     * Get & scan all modules.
     *
     * @return array
     */
    public function scan ()
    {
        $modules = parent::scan ();
        if ($this->config ('activator') === 'database')
        {
            if (Schema::hasTable ($this->config ('activators.database.table', 'gc_modules')))
            {
                $repo_modules = \Goodcatch\Modules\Laravel\Model\Module::get ();

                $repo_modules = $repo_modules
                    ->reduce(function ($arr, $module) {
                        if(!file_exists($module->path)){
                            $module->delete();
                        }
                        $arr->push($module);
                        return $arr;
                    },  \collect([]));

                foreach (Arr::except($modules, $repo_modules->pluck('name')->values()->all()) as $name => $module) {
                    $module->enable();
                }

                foreach (Arr::except($repo_modules
                    ->reduce(
                        function($arr, $item) {
                            $arr [$item->name] = $item;
                            return $arr;
                        }, []), \collect($modules)->keys()->all()) as $name => $module) {
                    if (! empty($module->path) && file_exists ($module->path)){
                        $modules [$module->name] = $this->createModule($this->app, $module->name, $module->path);
                    }

                }
            }
        }
        return $modules;
    }

    /**
     * Get & scan all modules.
     *
     * @return array
     */
    public function scanJson ()
    {
        $paths = $this->getScanPaths ();

        $modules = [];

        foreach ($paths as $key => $path) {
            $manifests = $this->getFiles()->glob ("{$path}/module.json");

            is_array($manifests) || $manifests = [];

            foreach ($manifests as $manifest) {
                try {
                    $module = Json::make ($manifest)->getAttributes ();
                    $module ['path'] = dirname ($manifest);
                    $modules [] = $module;
                } catch (\Exception $e) {

                }
            }
        }

        return $modules;
    }
}
