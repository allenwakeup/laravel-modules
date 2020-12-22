<?php

if (! function_exists ('light_config')) {

    /**
     *
     * 获取light config
     *
     * @param $key
     * @param null $default
     * @return \Illuminate\Config\Repository|mixed
     */
    function light_config($key, $default = null)
    {
        return config('light_config.' . $key, $default);
    }
}

if (! function_exists ('load_dictionary')) {

    /**
     * 利用light config string 类型的配置，转换成字典
     *
     * @param $input
     * @return array
     */
    function load_dictionary ($input)
    {
        $dict = [];
        $dict_items = explode(light_config('DICT_ITEM_SEPARATOR', ','), $input);
        if (isset ($dict_items) && sizeof($dict_items) > 0) {
            $dict_item_separator = light_config('DICT_KV_SEPARATOR', ':');
            foreach ($dict_items as $dict_item_str) {
                $eles = explode($dict_item_separator, $dict_item_str);
                $eles_size = sizeof($eles);

                if (isset ($eles) && $eles_size > 0) {
                    $val = $name = $eles [0];

                    if ($eles_size > 1) {
                        $val = $eles [1];
                    }

                    $dict [] = ['id' => $val, 'code' => $val, 'value' => $val, 'name' => $name];
                }
            }
        }
        return $dict;
    }
}

if (! function_exists ('light_dictionary')) {
    /**
     * 利用light config string 类型的配置，转换成字典
     *
     * @param $light_key
     * @param string $default
     * @return array
     */
    function light_dictionary($light_key, $default = '')
    {
        return load_dictionary(light_config($light_key, $default));
    }
}
