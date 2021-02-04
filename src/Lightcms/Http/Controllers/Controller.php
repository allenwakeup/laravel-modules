<?php

namespace Goodcatch\Modules\Lightcms\Http\Controllers;

use App\Http\Controllers\Controller as BaseController;
use Illuminate\Support\Facades\View;

class Controller extends BaseController
{
    public function __construct ()
    {
        parent::__construct ();

        View::share ('goodcatch-laravel-modules-integration', 'lightcms');
    }
}
