<?php

use Tenant\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $definedSettings = Setting::defined();

        foreach ($definedSettings as $key => $value) {
            Setting::firstOrCreate([
                "key" => $key
            ], ["value" => $value]);
        }
    }
}