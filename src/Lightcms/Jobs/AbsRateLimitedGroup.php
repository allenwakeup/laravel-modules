<?php

namespace Goodcatch\Modules\Lightcms\Jobs;

use Goodcatch\Modules\Lightcms\Jobs\Middleware\RateLimited;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class AbsRateLimitedGroup implements ShouldQueue
{

    public function middleware()
    {
        return [new RateLimited];
    }
}
