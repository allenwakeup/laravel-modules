<?php


namespace Goodcatch\Modules\Lightcms\Contracts\Permission;

use App\Model\Admin\Menu;
use App\Repository\Admin\MenuRepository;
use Goodcatch\Modules\Laravel\Contracts\Auth\PermissionProvider as Permission;
use Goodcatch\Modules\Lightcms\Jobs\FlushMenu;
use Illuminate\Support\Arr;

class PermissionProvider implements Permission
{

    /**
     * The application instance.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * The provider driver name.
     *
     * @var string
     */
    protected $driver;

    /**
     * Create a new Auth manager instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @param  string $driver
     * @return void
     */
    public function __construct ($app, $driver)
    {
        $this->app = $app;
        $this->driver = $driver;
    }

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

    /**
     * @inheritDoc
     */
    public function getDriver ()
    {
        return $this->driver;
    }

    /**
     * @inheritDoc
     */
    public function flush ()
    {
        dispatch (new FlushMenu ());
    }
}