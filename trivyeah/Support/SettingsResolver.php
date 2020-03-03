<?php

namespace TrivYeah\Support;

use Tenancy\Environment;
use Tenant\Models\Setting;
use Illuminate\Support\Str;
use TrivYeah\Support\RouteName;
use Illuminate\Contracts\Foundation\Application;

class SettingsResolver
{
    /**
     * The container
     */
    protected $app;

    /**
     * Tenancy Environments
     */
    protected $tenancy;

    /**
     * Default settings not set by tenants
     */
    protected $settings = [

    ];

    /**
     * @param Application
     * @param Environment
     */
    public function __construct(Application $app, Environment $tenancy)
    {
        $this->app = $app;
        $tenancy->identifyTenant();

        $this->tenancy = $tenancy;
        $this->loadSettings();
    }

    /**
     * Load Settings
     */
    public function loadSettings()
    {
        $this->settings = array_merge(
            $this->settings,
            Setting::defined()
        );
    }

    /**
     * Resolve Settings
     */
    public function resolve()
    {
        foreach ($this->settings as $setting => $default) {

            $value = tenant_config($setting, $default);
            $method = Str::camel($setting);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }
}