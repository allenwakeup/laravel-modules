<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Laravel\Repository;


use App\Repository\Searchable;

use Goodcatch\Modules\Laravel\Model\Module;

class ModuleRepository
{
    use Searchable;

    public static function list ($perPage, $condition = [])
    {

        $data = Module::query ()
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
