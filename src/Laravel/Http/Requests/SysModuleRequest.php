<?php

namespace Goodcatch\Modules\Laravel\Http\Requests;

use Goodcatch\Modules\Laravel\Model\SysModule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SysModuleRequest extends FormRequest
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
            'name' => 'required|max:50',
            'alias' => 'required|max:50',
            'description' => 'max:255',
            'priority' => 'integer',
            'version' => 'max:10',
            'path' => 'max:500',
            'sort' => 'integer',
            'type' => [
                'required',
                Rule::in ([SysModule::TYPE_SYSTEM, SysModule::TYPE_EXTEND])
            ],
            'status' => [
                'required',
                Rule::in ([SysModule::STATUS_DISABLE, SysModule::STATUS_ENABLE])
            ]
        ];


        return $rules;
    }

}
