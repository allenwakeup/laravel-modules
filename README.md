# Laravel Modules extension 

based on project [nwidart/laravel-modules](https://github.com/nwidart/laravel-modules)

## Introduction

The Goodcatch Laravel Modules library overwrite "nwidart/laravel-modules" service provider.

It extends "nwidart/laravel-modules" library, provide database activator.

Because of Laravel Package Discovery, "nwidart/laravel-modules" has been listed in composer.json.


## Installation

There might be a little bit more complicated things to do.

    * add required php composer library
    * do minor changes to laravel application
    * initialize application
    * add first goodcatch laravel-module 'Core'
    * getting started development
    * LightCMS: how to


### install library

```shell script

composer require goodcatch/laravel-modules

```

### modify Application

find file **/path_to_project/bootstrap/app.php**

change Kernel from app kernel to goodcatch kernel

for example

```php

// ...

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Goodcatch\Modules\Laravel\Console\Kernel::class
);


// ...

```

### for mcamara/laravel-localization
 
    make sure Laravel Localization default local is 'en' if no Laravel Localization supported locals
    in project configuration file 'project/config/laravellocalization.php' presents.

```php

// ...

return [

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => 'en',
];

// ...


```

    make sure laravel-localization is configured to laravel http kernel

```php

// ...
class Kernel extends HttpKernel
{

// ...


    /**
     * The application's route middleware.
     *
     * These middleware may be assigned to groups or used individually.
     *
     * @var array
     */
    protected $routeMiddleware = [

        // ...

        // localization

        'localize'                => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRoutes::class,
        'localizationRedirect'    => \Mcamara\LaravelLocalization\Middleware\LaravelLocalizationRedirectFilter::class,
        'localeSessionRedirect'   => \Mcamara\LaravelLocalization\Middleware\LocaleSessionRedirect::class,
        'localeCookieRedirect'    => \Mcamara\LaravelLocalization\Middleware\LocaleCookieRedirect::class,
        'localeViewPath'          => \Goodcatch\Modules\Laravel\Http\Middleware\LocalizationViewPath::class

        // ...

    ];

// ...

}

```


### Autoloading

By default the module classes are not loaded automatically. You can autoload your modules using `psr-4` if modules are placed in different folder. For example:

``` json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Goodcatch\\Modules\\": "storage/app/modules"
    }
  }
}
```

**Note: don't forget to make sure the folder 'storage/app/modules' exists or checkout environment configuration name 'MODULE_INSTALL_PATH'**.

**Tip: don't forget to run `composer dump-autoload` afterwards.**


### module admin pages

Goodcatch Modules providers admin page to show modules list and disable/enable module if you want it.

first of all, generate tables and then install them.

```shell script

php artisan goodcatch:table

php artisan migrate

php artisan goodcatch:cache

```

open modules admin page: http://domain/goodcatch/laravel-modules/modules


### install the first module Core

```shell script

composer require goodcatch/laravel-module-core

php artisan module:migrate core --seed

```

checkout modules admin page, there will be a module named 'Core'.


## Getting stated with development

### have not created any module yet, create it at first


Create first new module, the name is 'core'
    

```shell script

php artisan module:make core


```

### has already created module

For example, module name is core
    
Now, create module model against [LightCMS](https://github.com/eddy8/LightCMS) model

**php artisan goodcatch:module <model name> <name> <module name>**

```shell script

php artisan goodcatch:module article Article core


```

### Environments

```ini
# optional that pre-append module route path in url
# default to: m
MODULE_ROUTE_PREFIX=m

# optional that change the default modules path from app/Modules to new path
# default to: storage/app/modules
MODULE_INSTALL_PATH=storage/app/modules

# optional that update module
# default to: https://laravel-modules.goodcatch.cn/dl?p=%s&n=%s&v=%s&s=%s
MODULE_INSTALL_REPO_URL=https://laravel-modules.goodcatch.cn/dl?p=%s&n=%s&v=%s&s=%s

# optional that indicate base project that laravel-modules is going to work with
# optional values are 'lightcms', default to 'lightcms
MODULE_INTEGRATE=lightcms


```

### Lightcms part

#### publish resources and override

```shell script
php artisan vendor:publish --tag=goodcatch-modules-lightcms --force

```

#### route

[LightCMS](https://github.com/eddy8/lightcms) is CMS system based on Laravel.

Goodcatch Modules improved Lightcms Menu discovering.

change file **app/Providers/RouteServiceProvider.php**

```php

// ...

use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

// ...

    /**
     * Define the "admin" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapAdminRoutes()
    {

        Route::prefix (LaravelLocalization::setLocale ())
            ->middleware ('localeSessionRedirect', 'localizationRedirect', 'localeViewPath')
            ->group (function () {
                Route::prefix('admin')
                    ->middleware('web')
                    ->namespace($this->namespace . '\Admin')
                    ->group(base_path('routes/admin.php'));
        
                // override menu
                Route::prefix('admin')
                    ->middleware('web')
                    ->namespace('Goodcatch\Modules\Lightcms\Http\Controllers\Admin')
                    ->group (function() {
                        Route::group(['as' => 'admin::'], function() {
                            Route::middleware('log:admin', 'auth:admin', 'authorization:admin')
                                ->group(function() {
                                    Route::post('/menus/discovery', 'MenuController@discovery')->name('menu.discovery');
                                });
        
                        });
                    });
            });
       

        

// ...

```

#### front end

[Layui update](https://layui.com)

copy all of Layui files to folder **public/public/vendor/layui**


[xm-select](https://gitee.com/maplemei/xm-select)

```shell script
cd public/public/vendor/xm-select && wget https://gitee.com/maplemei/xm-select/raw/master/dist/xm-select.js
```

Licensed under [The MIT License (MIT)](LICENSE).

