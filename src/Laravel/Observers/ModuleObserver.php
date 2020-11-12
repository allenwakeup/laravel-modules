<?php


namespace Goodcatch\Modules\Laravel\Observers;

use Goodcatch\Modules\Laravel\Jobs\RefreshDatabaseModules;
use Goodcatch\Modules\Laravel\Model\Module;


/**
 * 更新缓存中的模块
 *
 * Class SysModuleObserver
 * @package App\Observers
 */
class ModuleObserver
{

    // creating, created, updating, updated, saving
    // saved, deleting, deleted, restoring, restored
    public function created (Module $module)
    {
        $this->fire ();
    }

    public function updated (Module $module)
    {
        $this->fire ();
    }

    public function deleted (Module $module)
    {
        $this->fire ();
    }

    private function fire ()
    {
        dispatch (new RefreshDatabaseModules ());
    }
}