<?php
/**
 * Date: 2019/2/27 Time: 10:48
 *
 * @author  Allen <ali@goodcatch.cn>
 * @version v1.0.0
 */

namespace Goodcatch\Modules\Lightcms\Repositories\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait Selectable
{
    public static function buildSelect(Builder $query, $condition, string $keyword)
    {
        // 获取模型定义的搜索域
        $model = $query->getModel();
        $searchField = [];
        if (property_exists($model, 'searchField')) {
            $searchField = $model::$searchField;
        }

        $query->whereExists(function ($query) use ($searchField, $condition, $keyword) {
            foreach ($searchField as $k => $v) {
                if (! array_key_exists ($k, $condition))
                {
                    $query->orWhere ($k, 'like', '%' . $keyword . '%');
                }
            }
        });
    }
}
