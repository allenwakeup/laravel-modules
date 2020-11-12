<?php


if (! function_exists ('module_config')) {
    /**
     * Get / set the specified configuration value from modules.
     *
     * If an array is passed as the key, we will assume you want to set an array of values.
     *
     * @param  array|string|null  $key
     * @param  mixed  $default
     * @return mixed|\Illuminate\Config\Repository
     */
    function module_config ($key, $default = null)
    {
        return config ('modules.' . $key, $default);
    }
}

if (! function_exists ('goodcatch_vendor_path')) {

    /**
     * Get this library path in project's vendor
     *
     * @return string
     */
    function goodcatch_vendor_path ($append = '')
    {
        return base_path () . '/vendor/goodcatch/laravel-modules/src' . $append;
    }
}

if (! function_exists ('goodcatch_resource_path')) {

    /**
     * Get this library resource path based on 'goodcatch_vendor_path'
     *
     * @return string
     */
    function goodcatch_resource_path ($append = '')
    {
        return goodcatch_vendor_path ('/resources') . $append;
    }
}

if (! function_exists ('module_defined_path')) {

    /**
     * -----------------------------------------------------------
     *
     * Laravel Module CUSTOM FUNCTIONS
     *
     * Read modules configs and find out path of given name.
     * The name is in config file 'config/modules.php'
     *   and key path is 'modules.paths.generator.[name]'.
     *
     * @param $name
     * @return bool|mixed
     */
    function module_defined_path ($name)
    {
        $path_conf = module_config ('paths.generator.' . $name, []);
        if (array_get ($path_conf, 'generate', false)) {
            return array_get ($path_conf, 'path', false);
        }
        return false;
    }
}

if (! function_exists ('module_generated_path')) {

    /**
     * Get module folder by a generation name
     *
     * @param $name
     * @param $generate
     * @param string $path
     * @return bool|string
     */
    function module_generated_path ($name, $generate, $path = '')
    {
        $generated = module_defined_path ($generate);
        if ($generated) {
            return module_path ($name, $generated . ($path ? DIRECTORY_SEPARATOR . $path : $path));
        }
        return false;
    }
}

if (! function_exists ('module_route_prefix')) {
    /**
     * Get route prefix from config 'modules.route.prefix', default to 'm'
     *
     * @param string $append append additional string
     * @return string
     */
    function module_route_prefix ($append = '')
    {
        return module_config ('route.prefix') . $append;
    }
}

