<?php

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

if (! function_exists ('_trans')) {
    /**
     * Translate the given message.
     * Otherwise show default string
     *
     * @param  string|null  $key
     * @param  string|null  $default
     * @param  array  $replace
     * @param  string|null  $locale
     * @return \Illuminate\Contracts\Translation\Translator|string|array|null
     */
    function _trans ($key, $default = null, $replace = [], $locale = null)
    {
        $trans = trans ($key, $replace, $locale);
        if(strcmp ($trans, $key) === 0)
        {
            return value ($default);
        }
        return $trans;
    }
}

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
     * Get project vendor path
     *
     * @param string $append
     * @return string
     */
    function goodcatch_vendor_path ($append = '')
    {
        return base_path () . '/vendor/goodcatch' . $append;
    }
}

if (! function_exists ('goodcatch_laravel_modules_path')) {

    /**
     * Get this library path in project's vendor
     *
     * @return string
     */
    function goodcatch_laravel_modules_path ($append = '')
    {
        return goodcatch_vendor_path () . '/laravel-modules/src' . $append;
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
        return goodcatch_vendor_path ('/laravel-modules/resources') . $append;
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

if (! function_exists ('module_tap')) {
    /**
     * Get route prefix from config 'modules.route.prefix', default to 'm'
     *
     * @param string $abstract application abstract id
     * @param closure $callback to tap
     * @param array $params with application abstract parameters
     * @return string
     */
    function module_tap ($abstract, $callback = null, $params = [])
    {
        if (! is_null ($callback) && app ()->has ($abstract))
        {
            return tap (app ($abstract, $params), $callback);
        }
        return $abstract;
    }
}

if (! function_exists ('collection2TreeData')) {
    /**
     *
     * grouped row data can be transformed to tree data
     *
     * @param Collection $data
     * @param $groups array|string
     * @param string $title
     * @param string $children
     * @param string $id
     * @param null $display
     * @return Collection
     */
    function collection2TreeData(Collection &$data, $groups, $title = 'title', $children = 'children', $id = 'id', $display = null)
    {
        if (is_array($groups) && count($groups) > 0) {
            $group = Arr::first($groups);
            $groups = array_slice($groups, 1);
            $data = $data
                ->groupBy(function ($item) use ($group) {
                    return Arr::get($item, $group, '--');
                })
                ->map(function ($item, $key) use ($groups, $title, $children, $id, $display) {
                    $node_children = collection2TreeData($item, $groups, $title, $children, $id, $display);
                    $node = [$title => $key];
                    if (count($groups) > 0) {
                        $node [$children] = $node_children->values()->all();
                    } else {
                        if ($item->count() === 1) {
                            $node = $item->transform(function ($trans) use ($title, $id, $display) {
                                if (!empty ($display)) {
                                    Arr::set($trans, $title, Arr::get($trans, $display));
                                }
                                Arr::set($trans, 'id', Arr::get($trans, $id));
                                return $trans;
                            })->first();
                        }
                    }
                    return $node;
                });
        } else if (is_string($groups)) {
            collection2TreeData($data, [$groups], $title, $children, $id, $display);
        }
        return $data;
    }

}
