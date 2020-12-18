<?php

namespace Goodcatch\Modules\Lightcms\Jobs;

use App\Repository\Admin\MenuRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Cache;

/**
 * Class RefreshItems
 *
 * @package Goodcatch\Modules\Lightcms\Jobs
 */
class FlushMenu implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    /**
     * 任务可以执行的最大秒数 (超时时间)。
     *
     * @var int
     */
    public $timeout = 240;

    /**
     * 任务可以尝试的最大次数。
     *
     * @var int
     */
    public $tries = 1;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {

    }

    /**
     * Execute the job.
     * 监控料品是否更新，并采取措施
     * 例如与远端数据同步或者数据校验
     *
     * @return void
     */
    public function handle ()
    {
        $data = MenuRepository::tree ();
        Cache::forget ('menu:tree');
        Cache::remember ('menu:tree', 60 * 60 * 24, function () use ($data) {
            return $data;
        });


    }
}
