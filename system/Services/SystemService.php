<?php

namespace System\Services;

use System\Models\User;
use System\Models\Hostname;
use TrivYeah\Support\Fluent;
use System\Models\Organization;
use System\Events\TenantCreated;
use Illuminate\Support\Facades\DB;
use Tenancy\Tenant\Events\Created;

class SystemService
{

    /**
     * Create a new Tenant
     * @param TrivYeah\Support\Fluent
     * 
     * @return Tenancy\Identification\Contracts\Tenant
     */
    public function createTenant(Fluent $tenantDto)
    {
        $tenant = DB::transaction(function () use ($tenantDto) {
            $tenant = Organization::firstOrCreate(
                (new Organization($tenantDto->toArray()))->toArray()
            );
    
            Hostname::firstOrCreate([
                "organization_id" => $tenant->id,
                "fqdn" => $tenantDto->fqdn], 
                (new Hostname($tenantDto->toArray()))->toArray()
            );

            return $tenant;
        });

        event(new TenantCreated($tenant, $tenantDto));

        return $tenant;
    }
}