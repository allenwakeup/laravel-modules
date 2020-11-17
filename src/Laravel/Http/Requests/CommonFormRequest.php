<?php

namespace Goodcatch\Modules\Laravel\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommonFormRequest extends FormRequest
{

    protected $uniqueOrExists = [];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize ()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [];
    }

    /**
     * Get rule name unique or exists whether field parameter value equals
     * instance original field value or not
     *
     * @param $clazz
     * @param $column
     * @param $value
     *
     * @return string unique or exists
     */
    protected function uniqueOrExists ($clazz, $column, $param = 'id')
    {
        $id = request ()->route ()->parameter ($param);
        if (isset ($id))
        {
            if (! array_has ($this->uniqueOrExists, $clazz))
            {
                $this->uniqueOrExists [$clazz] = $clazz::where ($param, $id);
            }
            if ($this->uniqueOrExists [$clazz]->where ($column, request ()->post ($column))->exists ())
            {
                return 'exists';
            }
        }
        return 'unique';
    }

}
