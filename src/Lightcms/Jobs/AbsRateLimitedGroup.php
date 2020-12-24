<?php

namespace Goodcatch\Modules\Lightcms\Jobs;

use App\Jobs\WriteSystemLog;
use Goodcatch\Modules\Laravel\Jobs\Middleware\RateLimited;
use Illuminate\Contracts\Queue\ShouldQueue;

abstract class AbsRateLimitedGroup implements ShouldQueue
{

    public function middleware()
    {
        return [new RateLimited];
    }


    /**
     * 延迟写入数据库
     *
     * @param array|null $message
     */
    protected function writeSysLogs (array $data)
    {
        dispatch (new WriteSystemLog ($data));
    }
}
