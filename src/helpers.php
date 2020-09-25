<?php

if (! function_exists('module_path')) {
    function goodcatch_module ($name, $path = '')
    {
        $module = app('modules')->find($name);

        return $module->getPath() . ($path ? DIRECTORY_SEPARATOR . $path : $path);
    }
}
