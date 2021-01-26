<?php


namespace Goodcatch\Modules\Lightcms\Contracts\Permission;

use Goodcatch\Modules\Laravel\Contracts\Auth\PermissionProvider as Permission;

class PermissionProvider implements Permission
{

    /**
     * @inheritDoc
     */
    public function query ()
    {
        // TODO: Implement query() method.
    }

    /**
     * @inheritDoc
     */
    public function save (array $values, array $unique)
    {
        // TODO: Implement save() method.
    }

    /**
     * @inheritDoc
     */
    public function find ($condition)
    {
        // TODO: Implement find() method.
    }

    /**
     * @inheritDoc
     */
    public function retrieve ($condition)
    {
        // TODO: Implement retrieve() method.
    }
}