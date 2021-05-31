<?php
/**
 * Date: 2019/3/4 Time: 13:54
 *
 * @author  Allen <ali@goodcatch.cn>
 * @version v1.0.0
 */

namespace Goodcatch\Modules\Laravel\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

abstract class Model extends BaseModel
{

    use Concerns\HasModulePrefix;

    /**
     * @var string module table with prefix
     * @return string prefix of table name
     */
    protected function getModuleTablePrefix () {
        return 'gc_';
    }

}
