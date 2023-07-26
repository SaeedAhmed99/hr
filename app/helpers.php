<?php

use App\Models\Setting;


if (!function_exists('setting')) {
    function setting($key)
    {
        if (!empty(config('database.connections.mysql.host'))) {
            $setting = Setting::where('name', $key)->first();
            return is_null($setting) ? NULL : $setting->value;
        }
    }
}

if (!function_exists('settingToTime')) {
    function settingToTime($seconds)
    {
        if (!empty(config('database.connections.mysql.host'))) {
            $setting = Setting::where('name', $seconds)->first();
            return is_null($setting) ? NULL : $setting->value;
        }
    }
}

if (!function_exists('userAvater')) {
    function userAvater($avatar)
    {
        if (!empty(config('database.connections.mysql.host'))) {
            if (is_null($avatar) or empty($avatar)) {
                return asset('storage/avatar/avatar.png');
            }
            return asset("storage/avatar/$avatar");
        }
    }
}

if (!function_exists('base_path')) {
    /**
     * Get the path to the base of the install.
     *
     * @param  string  $path
     * @return string
     */
    function base_path($path = '')
    {
        if (!empty(config('database.connections.mysql.host'))) {
            return app()->basePath($path);
        }
    }
}
