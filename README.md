# Laravel Modules extension 
======

based on project [nwidart/laravel-modules](https://github.com/nwidart/laravel-modules)

## Introduction

The goodcatch laravel modules library overwrite "nwidart/laravel-modules" service providers.

And, ignored package "nwidart/laravel-modules" in laravel package discovery.


## Installation

### install library

```
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

Licensed under [The MIT License (MIT)](LICENSE).

