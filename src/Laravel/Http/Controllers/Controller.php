<?php

namespace Goodcatch\Modules\Laravel\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    public function __construct ()
    {
        View::share ('goodcatch-laravel-modules-integration', Str::lower (app ('config')->get ('modules.integration')));
    }
}
