<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Lightcms\Repositories;

use Illuminate\Support\Arr;

class BaseRepository
{

    use Concerns\Selectable, Concerns\Searchable;


    const TRANSFORM_TYPE_JSON                       = 'json';

    protected static function transform ($type, array &$array, $field)
    {
        if (! empty (Arr::get ($array, $field, '')))
        {
            switch ($type)
            {
                case self::TRANSFORM_TYPE_JSON :
                    Arr::set ($array, $field, json_decode (Arr::get ($array, $field), true));
                break;
            }
        }
    }

}
