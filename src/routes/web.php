<?php
/**
 * Date: 2019/2/25 Time: 9:31
 *
 * @author  Allen <ali@goodcatch.cn>
 * @version v1.0.0
 */

Route::group(
    [
        'as' => 'web::',
    ],
    function () {

        // 自动加载模块所生成的路由
        $modules = app ('modules') ? app ('modules')->all () : [];

        foreach ($modules as $module_name => $module) {

            if ($module->isEnabled ()) {

                $path = module_generated_path ($module_name, 'routes') . '/web.php';

                if (file_exists ($path))
                {
                    Route::prefix (module_route_prefix ())
                        ->namespace ($module_name)
                        ->name (module_route_prefix ('.'))
                        ->group (function () use ($module_name, $module, $path) {

                            Route::prefix ($module->getLowerName ())
                                ->namespace (app ('config')->get ('modules.route.front.namespace') ?? 'Http\\Controllers\\Front')
                                ->name ($module->getLowerName () . '.')
                                ->group ($path);

                        });
                }


            }
        }



    }
);
