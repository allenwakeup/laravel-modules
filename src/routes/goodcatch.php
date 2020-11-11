<?php
/**
 * Date: 2019/2/25 Time: 9:31
 *
 * @author  Allen <ali@goodcatch.cn>
 * @version v1.0.0
 */

Route::group(
    [
        'as' => 'admin::',
    ],
    function () {

        Route::middleware ('log:admin', 'auth:admin', 'authorization:admin')->group (function () {
            Route::prefix ('laravel-modules')
            ->namespace ('Laravel\\Http\\Controllers')
            ->name (module_route_prefix ('.goodcatch.'))
            ->group (function () {
                // GoodcatchCN 模块管理
                Route::get('/modules', 'SysModuleController@index')->name('module.index');
                Route::get('/modules/list', 'SysModuleController@list')->name('module.list');
                Route::get('/modules/create', 'SysModuleController@create')->name('module.create');
                Route::post('/modules', 'SysModuleController@save')->name('module.save');
                Route::get('/modules/{id}/edit', 'SysModuleController@edit')->name('module.edit');
                Route::put('/modules/{id}', 'SysModuleController@update')->name('module.update');
                Route::delete('/modules/{id}', 'SysModuleController@delete')->name('module.delete');
            });
        });
    }
);