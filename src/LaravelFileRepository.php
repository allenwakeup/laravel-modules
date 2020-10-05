<?php

namespace Goodcatch\Modules;

use Illuminate\Support\Arr;
use Nwidart\Modules\FileRepository;
use Nwidart\Modules\Json;
use Nwidart\Modules\Laravel\Module;

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
     * Get & scan all modules.
     *
     * @return array
     */
    public function scanJson ()
    {
        $paths = $this->getScanPaths();

        $modules = [];

        foreach ($paths as $key => $path) {
            $manifests = $this->getFiles()->glob("{$path}/module.json");

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
