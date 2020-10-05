<?php
/**
 * Date: 2019/2/25 Time: 9:31
 *
 * @author  Allen <ali@goodcatch.cn>
 * @version v1.0.0
 */

use Illuminate\Support\Str;


$modules = app ('modules') ? app ('modules')->all () : [];

Route::group(
    [
        'as' => 'admin::',
    ],
    function () use ($modules) {

        Route::middleware ('log:admin', 'auth:admin', 'authorization:admin')->group (function () use ($modules) {
            // 自动加载模块所生成的路由


            foreach ($modules as $module_name => $module) {

                if ($module->isEnabled ()) {


                    Route::prefix (module_route_prefix ())
                        ->namespace ($module_name)
                        ->name (module_route_prefix ('.'))
                        ->group (function () use ($module_name, $module) {

                            Route::prefix ($module->getLowerName ())
                                ->namespace (app ('config')->get ('modules.route.backend.namespace') ?? 'Http\\Controllers\\Admin')
                                ->name ($module->getLowerName () . '.')
                                ->group (function () use ($module_name, $module) {

                                    Route::get ('/', $module_name . 'Controller@index')->name ('index');
                                    $routes_path = module_generated_path ($module_name, 'routes') . '/auto';
                                    if (is_dir ($routes_path)) {
                                        foreach (new DirectoryIterator ($routes_path) as $f) {
                                            if ($f->isDot ()) {
                                                continue;
                                            }
                                            $name = $f->getPathname ();
                                            if ($f->isFile () && Str::endsWith ($name, '.php')) {
                                                require $name;
                                            }
                                        }
                                    }
                                });


                        });
                }
            }

        });

    }
);

// 前端
Route::group(
    [
        'as' => 'member::',
    ],
    function () use ($modules) {
        Route::middleware ('auth:member')->group (function () use ($modules) {
            // 自动加载模块所生成的路由
            foreach ($modules as $module_name => $module) {
                $routes_path = module_generated_path ($module_name, 'routes') . '/member.php';
                if ($module->isEnabled () && file_exists ($routes_path)) {
                    Route::namespace ($module_name . '\\' . app ('config')->get ('modules.route.frontend.namespace') ?? 'Http\\Controllers\\Front')
                        ->name (module_route_prefix ('.' . $module->getLowerName () . '.member.'))
                        ->group (function () use ($module_name, $module, $routes_path) {
                            require $routes_path;
                        });
                }
            }
        });
    }
);