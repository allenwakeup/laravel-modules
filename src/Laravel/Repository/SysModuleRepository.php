<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Laravel\Repository;


use App\Repository\Searchable;

use Goodcatch\Modules\Laravel\Model\SysModule;

class SysModuleRepository
{
    use Searchable;

    public static function list ($perPage, $condition = [])
    {

        $data = SysModule::query ()
            ->where (function ($query) use ($condition) {
                Searchable::buildQuery ($query, $condition);
            })
            ->orderBy ('id', 'desc')
            ->paginate ($perPage);
        $data->transform (function ($item) {
            $item->editUrl = route ('admin::' . module_route_prefix ('.goodcatch.') . 'module.edit', ['id' => $item->id]);
            $item->deleteUrl = route ('admin::' . module_route_prefix ('.goodcatch.') . 'module.delete', ['id' => $item->id]);
            return $item;
        });

        return [
            'code' => 0,
            'msg' => '',
            'count' => $data->total (),
            'data' => $data->items (),
        ];
    }

    public static function add ($data)
    {
        return SysModule::query ()->create ($data);
    }

    public static function update ($id, $data)
    {
        return self::find ($id)->update ($data);
    }

    public static function find ($id)
    {
        return SysModule::query ()->find ($id);
    }

    public static function delete ($id)
    {
        return SysModule::destroy ($id);
    }
}
