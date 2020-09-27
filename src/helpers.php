<?php

if (! function_exists('module_defined_path')) {

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
        $path_conf = config ('modules.paths.generator.' . $name, []);
        if (array_get ($path_conf, 'generate', false)) {
            return array_get ($path_conf, 'path', false);
        }
        return false;
    }
}

if (! function_exists('module_generated_path')) {

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

if (! function_exists('module_route_prefix')) {
    /**
     * Get route prefix from config 'modules.route.prefix', default to 'm'
     *
     * @param string $append append additional string
     * @return string
     */
    function module_route_prefix ($append = '')
    {
        return config('modules.route.prefix') . $append;
    }
}