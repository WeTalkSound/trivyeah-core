<?php

use Tenant\Models\Setting;
use Tenancy\Facades\Tenancy;

if (! function_exists("tenant_path")) {

    function tenant_path($path = '') {
        $path = $path ? "tenant" . DIRECTORY_SEPARATOR . $path : '';
        
        return base_path($path);
    }
}

if (! function_exists("tenant_config")) {

    function tenant_config($key, $default = null) {

        if (Tenancy::getTenant())  {
            $setting = Setting::where("key", $key)->first();

            return $setting ? $setting->value : $default;
        }
        return $default;
    }
}

if (! function_exists("tenant_migration_path")) {

    function tenant_migration_path($path = '') {
        $basePath = "database" . DIRECTORY_SEPARATOR .  "migrations";
        $path = $path ? $basePath . DIRECTORY_SEPARATOR . $path : $basePath;
        
        return tenant_path($path);
    }
}