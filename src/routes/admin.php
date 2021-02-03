<?php

Route::group(
    [
        'as' => 'admin::',
    ],
    function () {

        Route::middleware ('log:admin', 'auth:admin', 'authorization:admin')->group (function () {
            Route::prefix ('laravel-modules')
                ->name (module_route_prefix ('.goodcatch.'))
                ->group (function () {
                    // GoodcatchCN 模块管理
                    Route::get('/modules', 'ModuleController@index')->name('module.index');
                    Route::get('/modules/list', 'ModuleController@list')->name('module.list');
                    Route::get('/modules/create', 'ModuleController@create')->name('module.create');
                    Route::post('/modules', 'ModuleController@save')->name('module.save');
                    Route::get('/modules/{id}/edit', 'ModuleController@edit')->name('module.edit');
                    Route::put('/modules/{id}', 'ModuleController@update')->name('module.update');
                    Route::delete('/modules/{id}', 'ModuleController@delete')->name('module.delete');
                });
        });
    }
);
