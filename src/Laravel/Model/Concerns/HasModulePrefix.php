<?php
/**
 * Date: 2019/3/4 Time: 13:54
 *
 * @author  Allen <ali@goodcatch.cn>
 * @version v1.0.0
 */

namespace Goodcatch\Modules\Laravel\Model\Concerns;

use Illuminate\Support\Str;

trait HasModulePrefix
{

    /**
     * set model table prefix in modules
     *
     * @return string
     */
    protected function getModuleTablePrefix ()
    {
        return '';
    }

    /**
     * Set the table associated with the model.
     *
     * @param  string  $table
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function setTable ($table)
    {
        if (! empty ($table) && ! Str::startsWith ($table, $this->getModuleTablePrefix ()))
        {
            $table = $this->getModuleTablePrefix () . $table;
        }
        if ($this->table !== $table)
        {

            $this->table = $table;
        }


        return $this;
    }

    /**
     * Get the table associated with the model.
     *
     * @return string
     */
    public function getTable ()
    {
        if (empty ($this->table))
        {
            $this->setTable (parent::getTable ());
        }
        return parent::getTable ();
    }

    /**
     * Encode the given value as JSON.
     *
     * @param mixed $value
     * @return string
     */
    protected function asJson ($value)
    {
        return json_encode ($value, JSON_UNESCAPED_UNICODE);
    }
}
