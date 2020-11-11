<?php


namespace Goodcatch\Modules\Laravel\Observers;

use Goodcatch\Modules\Laravel\Model\SysModule;
use Illuminate\Support\Facades\Cache;


/**
 * 更新缓存中的模块
 *
 * Class SysModuleObserver
 * @package App\Observers
 */
class SysModuleObserver
{

    // creating, created, updating, updated, saving
    // saved, deleting, deleted, restoring, restored
    public function created (SysModule $Item)
    {
        $this->fire ();
    }

    public function updated (SysModule $Item)
    {
        $this->fire ();
    }

    public function deleted (SysModule $Item)
    {
        $this->fire ();
    }

    private function fire ()
    {
        $config = app ('config');
        if ($config->get ('modules.cache.enable'))
        {
            Cache::forget ($config->get ('modules.cache.key'));
        }
    }
}