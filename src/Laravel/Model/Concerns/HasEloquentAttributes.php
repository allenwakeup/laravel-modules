<?php


/**
 *
 * This file <HasEloquentAttributes.php> was created by <PhpStorm> at <2021/2/5>,
 * and it is part of project <laravel-modules>.
 * @author  Allen Li <ali@goodcatch.cn>
 */

namespace Goodcatch\Modules\Laravel\Model\Concerns;


trait HasEloquentAttributes
{
    public function isOwnerOf ($model)
    {
        $simple_name = Str::snake (class_basename ($model)) . '_id';
        return $this->id === $model->{$simple_name};
    }
}