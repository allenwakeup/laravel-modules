<?php

namespace Goodcatch\Modules\Laravel\Http\Requests;

use Goodcatch\Modules\Laravel\Model\Module;
use Goodcatch\Modules\Laravel\Http\Requests\CommonFormRequest as FormRequest;
use Illuminate\Validation\Rule;

class ModuleRequest extends FormRequest
{



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules ()
    {
        $module_table_name = module_config ('activators.database.table', 'gc_modules');

        return [
            'name' => ['required', 'max:50', $this->uniqueOrExists (Module::class, 'name') . ':' . $module_table_name],
            'alias' => ['required', 'max:50', $this->uniqueOrExists (Module::class, 'alias') . ':' . $module_table_name],
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

    }

}
