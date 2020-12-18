<?php

namespace Goodcatch\Modules\Lightcms\Jobs;

use App\Jobs\WriteSystemLog;
use Carbon\Carbon;
use Goodcatch\Modules\Lightcms\Jobs\Middleware\RateLimited;
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
    protected function writeLogs (array $message = null)
    {
        $now = Carbon::now ();
        dispatch (new WriteSystemLog([
            'user_id' => $this->scheduleLogId,
            'user_name' => $this->scheduleLogName,
            'url' => get_class ($this),
            'ua' => $this->schedule_failed ? 'true' : 'false',
            'ip' => '',
            'type' => $this->scheduleLogType,
            'data' => implode ('; ', is_null ($message) ? $this->schedule_output : $message),
            'updated_at' => $now,
            'created_at' => $now
        ]));
    }
}
