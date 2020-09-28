<?php

namespace Goodcatch\Modules;

use Nwidart\Modules\FileRepository;
use Nwidart\Modules\Laravel\Module;

class LaravelFileRepository extends FileRepository
{
    /**
     * {@inheritdoc}
     */
    protected function createModule(...$args)
    {
        return new Module(...$args);
    }
}
