<?php

use Goodcatch\Modules\Activators\DatabaseActivator;
use Nwidart\Modules\Activators\FileActivator;

/*
 * -------------------
 * Environment Variables
 *
 *  # defined prefix for module route url, default to 'm'
 *  MODULE_ROUTE_PREFIX=m
 *  # defined modules repository url
 *  MODULE_INSTALL_REPO_URL=https://laravel-modules.goodcatch.cn/dl?p=%s&n=%s&v=%s&s=%s
 *
 */
return [

    /*
    |--------------------------------------------------------------------------
    | Module Namespace
    |--------------------------------------------------------------------------
    |
    | Default module namespace.
    |
    */

    'namespace' => 'Goodcatch\Modules',

    /*
    |--------------------------------------------------------------------------
    | Module Stubs
    |--------------------------------------------------------------------------
    |
    | Default module stubs.
    |
    */

    'stubs' => [
        'enabled' => true,
        // 'path' => base_path () . '/vendor/nwidart/laravel-modules/src/Commands/stubs',
        'path' => goodcatch_laravel_modules_path ('/Commands/stubs'),
        'files' => [
            'routes/web' => 'routes/web.php',
            'routes/api' => 'routes/api.php',
            'views/index' => 'resources/views/index.blade.php',
            'views/master' => 'resources/views/layouts/master.blade.php',
            'scaffold/config' => 'config/config.php',
            'composer' => 'composer.json',
            'assets/js/app' => 'resources/assets/js/app.js',
            'assets/sass/app' => 'resources/assets/sass/app.scss',
            'webpack' => 'webpack.mix.js',
            'package' => 'package.json',
            'phpunit' => 'phpunit.xml',
            'helpers' => 'src/helpers.php'
        ],
        'replacements' => [
            'routes/web' => ['LOWER_NAME', 'STUDLY_NAME'],
            'routes/api' => ['LOWER_NAME'],
            'webpack' => ['LOWER_NAME'],
            'json' => ['LOWER_NAME', 'STUDLY_NAME', 'MODULE_NAMESPACE', 'PROVIDER_NAMESPACE'],
            'views/index' => ['LOWER_NAME'],
            'views/master' => ['LOWER_NAME', 'STUDLY_NAME'],
            'scaffold/config' => ['STUDLY_NAME'],
            'composer' => [
                'LOWER_NAME',
                'STUDLY_NAME',
                'VENDOR',
                'AUTHOR_NAME',
                'AUTHOR_EMAIL',
                'MODULE_NAMESPACE',
                'PROVIDER_NAMESPACE',
            ],
        ],
        'gitkeep' => false,
    ],
    'paths' => [
        /*
        |--------------------------------------------------------------------------
        | Modules path
        |--------------------------------------------------------------------------
        |
        | This path used for save the generated module. This path also will be added
        | automatically to list of scanned folders.
        |
        */

        'modules' => base_path (env ('MODULE_INSTALL_PATH', 'storage/app/modules')),
        /*
        |--------------------------------------------------------------------------
        | Modules assets path
        |--------------------------------------------------------------------------
        |
        | Here you may update the modules assets path.
        |
        */

        'assets' => public_path ('modules'),
        /*
        |--------------------------------------------------------------------------
        | The migrations path
        |--------------------------------------------------------------------------
        |
        | Where you run 'module:publish-migration' command, where do you publish the
        | the migration files?
        |
        */

        'migration' => base_path ('database/migrations'),
        /*
        |--------------------------------------------------------------------------
        | Generator path
        |--------------------------------------------------------------------------
        | Customise the paths where the folders will be generated.
        | Set the generate key to false to not generate that folder
        */
        'generator' => [
            'config' => ['path' => 'config', 'generate' => true],
            'command' => ['path' => 'src/Console', 'generate' => true, 'namespace' => 'Console'],
            'migration' => ['path' => 'database/migrations', 'generate' => true],
            'seeder' => ['path' => 'database/seeds', 'generate' => true, 'namespace' => 'Database\\Seeders'],
            'factory' => ['path' => 'database/factories', 'generate' => true],
            'model' => ['path' => 'src/Models', 'generate' => true, 'namespace' => 'Models'],
            'routes' => ['path' => 'routes', 'generate' => true],
            'controller' => ['path' => 'src/Http/Controllers', 'generate' => true, 'namespace' => 'Http\\Controllers'],
            'filter' => ['path' => 'src/Http/Middleware', 'generate' => true, 'namespace' => 'Http\\Middleware'],
            'request' => ['path' => 'src/Http/Requests', 'generate' => true, 'namespace' => 'Http\\Requests'],
            'provider' => ['path' => 'src/Providers', 'generate' => true, 'namespace' => 'Providers'],
            'assets' => ['path' => 'resources/assets', 'generate' => true],
            'lang' => ['path' => 'resources/lang', 'generate' => true],
            'views' => ['path' => 'resources/views', 'generate' => true],
            'test' => ['path' => 'tests/Unit', 'generate' => true],
            'test-feature' => ['path' => 'tests/Feature', 'generate' => true],
            'repository' => ['path' => 'src/Repositories', 'generate' => false, 'namespace' => 'Repositories'],
            'event' => ['path' => 'src/Events', 'generate' => false, 'namespace' => 'Events'],
            'listener' => ['path' => 'src/Listeners', 'generate' => false, 'namespace' => 'Listeners'],
            'policies' => ['path' => 'src/Policies', 'generate' => false, 'namespace' => 'Policies'],
            'rules' => ['path' => 'src/Rules', 'generate' => false, 'namespace' => 'Rules'],
            'jobs' => ['path' => 'src/Jobs', 'generate' => false, 'namespace' => 'Jobs'],
            'emails' => ['path' => 'src/Emails', 'generate' => false, 'namespace' => 'Emails'],
            'notifications' => ['path' => 'src/Notifications', 'generate' => false, 'namespace' => 'Notifications'],
            'resource' => ['path' => 'src/Http/Resources', 'generate' => true, 'namespace' => 'Http\\Resources']
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Scan Path
    |--------------------------------------------------------------------------
    |
    | Here you define which folder will be scanned. By default will scan vendor
    | directory. This is useful if you host the package in packagist website.
    |
    */

    'scan' => [
        'enabled' => true,
        'paths' => [
            base_path ('vendor/goodcatch/*'),
            storage_path ('app/modules'),
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Composer File Template
    |--------------------------------------------------------------------------
    |
    | Here is the config for composer.json file, generated by this package
    |
    */

    'composer' => [
        'vendor' => 'goodcatch',
        'author' => [
            'name' => 'Allen Li',
            'email' => 'ali@goodcatch.cn',
        ],
    ],


    /*
    |--------------------------------------------------------------------------
    | Caching
    |--------------------------------------------------------------------------
    |
    | Here is the config for setting up caching feature.
    |
    */
    'cache' => [
        'enabled' => true,
        'key' => 'laravel-modules',
        'lifetime' => 60,
    ],
    /*
    |--------------------------------------------------------------------------
    | Choose what laravel-modules will register as custom namespaces.
    | Setting one to false will require you to register that part
    | in your own Service Provider class.
    |--------------------------------------------------------------------------
    */
    'register' => [
        'translations' => true,
        /**
         * load files on boot or register method
         *
         * Note: boot not compatible with asgardcms
         *
         * @example boot|register
         */
        'files' => 'register',
    ],

    /*
    |--------------------------------------------------------------------------
    | Activators
    |--------------------------------------------------------------------------
    |
    | You can define new types of activators here, file, database etc. The only
    | required parameter is 'class'.
    | The file activator will store the activation status in storage/installed_modules
    */
    'activators' => [
        'file' => [
            'class' => FileActivator::class,
            'statuses-file' => base_path ('modules_statuses.json'),
            'cache-key' => 'activator.installed',
            'cache-lifetime' => 604800,
        ],
        'database' => [
            'class' => DatabaseActivator::class,
            'table' => 'gc_modules',
            'cache-key' => 'db-activator.installed',
            'cache-lifetime' => 604800,
        ],
    ],

    'activator' => env ('MODULE_ACTIVATOR', 'database'),

    /*
    |--------------------------------------------------------------------------
    | Route for modules
    |--------------------------------------------------------------------------
    |
    | You can define prefix of route name here, default to m.
    | The request url to modules follow this prefix
    */
    'route' => [

        'prefix' => env ('MODULE_ROUTE_PREFIX', 'm')

    ],

    /*
    |--------------------------------------------------------------------------
    | Install module from http url
    |--------------------------------------------------------------------------
    |
    | You can define http url patten in environment file, default to goodcatch.cn.
    | With the help of php sprintf function, you can provide placeholders if necessary.
    |
    */
    'install' => [
        'http' => env ('MODULE_INSTALL_REPO_URL', 'https://laravel-modules.goodcatch.cn/dl?p=%s&n=%s&v=%s&s=%s'),
    ]
];
