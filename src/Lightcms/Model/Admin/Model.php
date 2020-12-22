<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Lightcms\Model\Admin;

use App\Model\Admin\Model as BaseModel;
use Goodcatch\Modules\Laravel\Model\Concerns\HasModulePrefix;

abstract class Model extends BaseModel
{

    use HasModulePrefix;

    /**
     * @var string module table with prefix
     */
    protected function getModuleTablePrefix () {
        return 'gc_';
    }

}
