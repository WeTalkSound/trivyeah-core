<?php

namespace System\Services;

use System\Models\User;
use System\Models\Hostname;
use System\Models\Organization;
use Illuminate\Support\Facades\DB;
use Tenancy\Tenant\Events\Created;

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

    /**
     * Create a system user
     * @param array $userInformation
     */
    public function createUser(array $userInformation)
    {
        $user = new User;

        $user->fill($userInformation)->save();

        return $user;
    }
}