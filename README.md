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

...

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    Goodcatch\Modules\Laravel\Console\Kernel::class
);


...

```



Licensed under [The MIT License (MIT)](LICENSE).

