<?php

namespace Goodcatch\Modules\Laravel\Http\Requests;

use Goodcatch\Modules\Laravel\Model\Module;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ModuleRequest extends FormRequest
{

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
    public function rules ()
    {

        $rules = [
            'description' => 'max:255',
            'priority' => 'integer',
            'version' => 'max:10',
            'path' => 'max:500',
            'sort' => 'integer',
            'type' => [
                'required',
                Rule::in ([Module::TYPE_SYSTEM, Module::TYPE_EXTEND])
            ],
            'status' => [
                'required',
                Rule::in ([Module::STATUS_DISABLE, Module::STATUS_ENABLE])
            ]
        ];

        switch ($this->method ()) {
            case 'POST':
                $rules ['name'] = ['required', 'max:50', 'unique:' . module_config ('activators.database.table', 'gc_modules')];
                $rules ['alias'] = ['required', 'max:50', 'unique:' . module_config ('activators.database.table', 'gc_modules')];
                break;
            default:
                $rules ['name'] = 'required|max:50';
                $rules ['alias'] = 'required|max:50';
                break;
        }

        return $rules;
    }

}
