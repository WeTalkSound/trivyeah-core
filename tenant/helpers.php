<?php

if (! function_exists("tenant_path")) {

    function tenant_path($path = '') {
        $path = $path ? "tenant" . DIRECTORY_SEPARATOR . $path : '';
        
        return base_path($path);
    }
}