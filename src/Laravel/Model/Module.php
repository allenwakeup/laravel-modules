<?php
/**
 * @author  Allen <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Laravel\Model;

class Module extends Model
{

    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 0;

    const TYPE_SYSTEM = 1;
    const TYPE_EXTEND = 2;

    protected $guarded = [];

    /**
     * enabled modules
     *
     * @param $query
     * @return mixed
     */
    public function scopeOfEnabled ($query)
    {
        return $query->where ('status', self::STATUS_ENABLE);
    }

    public function getIsEnabledAttribute ()
    {
        return $this->status === self::STATUS_ENABLE;
    }

    public function getPathAttribute ($value)
    {

        if (empty (trim ($value)) || empty (ltrim ($value, '/')))
        {
            return storage_path ('app/modules')
                . '/' . $this->name . '/' . ltrim ($value, '/');

        }

        return $value;
    }

}
