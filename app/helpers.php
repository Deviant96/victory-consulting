<?php

use App\Models\Setting;

if (!function_exists('settings')) {
    /**
     * Get or set settings
     * 
     * @param string|null $key
     * @param mixed $default
     * @return mixed|\App\Models\Setting
     */
    function settings($key = null, $default = null)
    {
        if ($key === null) {
            return new Setting();
        }

        return Setting::get($key, $default);
    }
}
