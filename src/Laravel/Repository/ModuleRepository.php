<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Laravel\Repository;

use Goodcatch\Modules\Laravel\Model\Module;

class ModuleRepository
{

    public static function all ()
    {
        return Module::ofEnabled ()->get ()->toArray ();
    }

    public static function add ($data)
    {
        return Module::query ()->create ($data);
    }

    public static function update ($id, $data)
    {
        return self::find ($id)->update ($data);
    }

    public static function find ($id)
    {
        return Module::query ()->find ($id);
    }

    public static function delete ($id)
    {
        return Module::destroy ($id);
    }
}
