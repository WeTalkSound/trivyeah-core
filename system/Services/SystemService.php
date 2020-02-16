<?php

namespace System\Services;

use System\Models\Hostname;
use Illuminate\Support\Facades\DB;
use Tenancy\Tenant\Events\Created;
use System\Models\Organization;

class SystemService
{

    /**
     * Create a new Tenant
     * @param array
     * 
     * @return Tenancy\Identification\Contracts\Tenant
     */
    public function createTenant(array $tenantInformation)
    {
        $tenant = DB::transaction(function () use ($tenantInformation) {
            $tenant = Organization::firstOrCreate(
                (new Organization($tenantInformation))->toArray()
            );
    
            Hostname::firstOrCreate([
                "organization_id" => $tenant->id,
                "fqdn" => $tenantInformation["fqdn"]], 
                (new Hostname($tenantInformation))->toArray()
            );

            return $tenant;
        });

        event(new Created($tenant));

        return $tenant;
    }
}