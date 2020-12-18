# Laravel Modules extension 
======

based on project [nwidart/laravel-modules](https://github.com/nwidart/laravel-modules)

## Introduction

The goodcatch laravel modules library overwrite "nwidart/laravel-modules" service providers.

And, ignored package "nwidart/laravel-modules" in laravel package discovery.


## Installation

### install library

```shell script

composer require nwidart/laravel-modules

composer require goodcatch/laravel-modules

```

### modify Application

find file **/path_to_project/bootstrap/app.php**

change Kernal from app kernel to goodcatch kernel

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

**Note: don't forget to make sure the folder **storage/app/modules** exists or checkout environment configuration name **MODULE_INSTALL_PATH**.

**Tip: don't forget to run `composer dump-autoload` afterwards.**

## Getting stated with development

### have not created any module yet, create it at first


Create first new module, the name is 'core'
    

```shell script

php artisan module:make core


```

### has already created module

For example, module name is core
    
Now, create module model against [LightCMS](https://github.com/eddy8/LightCMS) model

**php artisan goodcatch:module model name module**

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



```

Licensed under [The MIT License (MIT)](LICENSE).

