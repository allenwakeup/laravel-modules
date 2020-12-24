<?php

namespace Goodcatch\Modules\Laravel\Jobs\Middleware;


use Illuminate\Support\Facades\Redis;

class RateLimited
{
    /**
     * 处理队列中的任务.
     *
     * @param mixed $job
     * @param callable $next
     * @return mixed
     * @throws \Illuminate\Contracts\Redis\LimiterTimeoutException
     */
    public function handle($job, $next)
    {
        Redis::throttle('key')
            ->block(0)->allow(1)->every(5)
            ->then(function () use ($job, $next) {
                // 锁定…

                $next($job);
            }, function () use ($job) {
                // 无法获取锁…

                $job->release(5);
            });
    }
}
