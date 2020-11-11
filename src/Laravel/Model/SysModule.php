<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Laravel\Model;

use Illuminate\Database\Eloquent\Model as BaseModel;

class SysModule extends BaseModel
{

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;

    const TYPE_SYSTEM = 1;
    const TYPE_EXTEND = 2;

    protected $table = 'modules';

    protected $guarded = [];

}
