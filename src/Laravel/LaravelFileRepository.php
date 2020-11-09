<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Laravel;


use Nwidart\Modules\FileRepository;
use Nwidart\Modules\Json;
use Nwidart\Modules\Laravel\Module;
use Nwidart\Modules\Process\Updater;
use Goodcatch\Modules\Process\Installer;

class LaravelFileRepository extends FileRepository
{
    /**
     * {@inheritdoc}
     */
    protected function createModule (...$args)
    {
        return new Module (...$args);
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
     * @return \Symfony\Component\Process\Process
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
    public function scanJson ()
    {
        $paths = $this->getScanPaths ();

        $modules = [];

        foreach ($paths as $key => $path) {
            $manifests = $this->getFiles()->glob ("{$path}/module.json");

            is_array($manifests) || $manifests = [];

            foreach ($manifests as $manifest) {
                try {
                    $modules [] = Json::make ($manifest)->getAttributes ();
                } catch (\Exception $e) {

                }
            }
        }

        return $modules;
    }
}
