<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Laravel\Model;

use App\Model\Admin\Model;

class SysModule extends Model
{

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;

    public static $searchField = [
        'name' => '名称',
        'description' => '描述',

    ];

    public static $listField = [

        'name' => '名称',
        'description' => '描述',

    ];

    protected $guarded = [];
}
