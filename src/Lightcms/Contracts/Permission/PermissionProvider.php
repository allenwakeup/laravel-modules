<?php


namespace Goodcatch\Modules\Lightcms\Contracts\Permission;

use App\Model\Admin\Menu;
use App\Repository\Admin\MenuRepository;
use Goodcatch\Modules\Laravel\Contracts\Auth\PermissionProvider as Permission;
use Illuminate\Support\Arr;

class PermissionProvider implements Permission
{

    /**
     * @inheritDoc
     */
    public function query ()
    {
        return Menu::query ();
    }

    /**
     * @inheritDoc
     */
    public function save (array $values, array $unique)
    {
        return Menu::updateOrCreate ($unique, $values);
    }

    /**
     * @inheritDoc
     */
    public function find ($condition)
    {
        return Menu::where ($condition)->first ();
    }

    /**
     * @inheritDoc
     */
    public function retrieve ($condition)
    {
        return MenuRepository::root (Arr::get ($condition, 'route'), Arr::get ($condition, 'tree'));
    }
}