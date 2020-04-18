<?php

namespace System\Services;

use System\Models\User;
use System\Models\Hostname;
use TrivYeah\Support\Fluent;
use System\Models\Organization;
use System\Events\TenantCreated;
use Illuminate\Support\Facades\DB;
use Tenancy\Tenant\Events\Created;
use TrivYeah\Support\ResponseHelper;

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

            $fqdn = $this->generateBaseFqdn($tenantDto->sub_domain);

            if ($this->host($fqdn)) ResponseHelper::fail(
                "organization with sub domain already exists"
            );

            $tenantDto->is_base = true;

            Hostname::firstOrCreate([
                "organization_id" => $tenant->id,
                "fqdn" => $fqdn], 
                (new Hostname($tenantDto->toArray()))->toArray()
            );

            return $tenant;
        });

        event(new TenantCreated($tenant, $tenantDto));

        return $tenant;
    }

    public function generateBaseFqdn($sub_domain)
    {
        return $sub_domain . "." . request()->getHttpHost();
    }

    public function host($fqdn)
    {
        return Organization::whereHas("hostNames", function ($hostname) use ($fqdn) {
            return $hostname->where("fqdn", $fqdn);
        })->first();
    }

    public function bootstrapTenant(Fluent $dto)
    {
        $organization = $this->host($dto->fqdn);

        return $organization ?: ResponseHelper::fail(
                "organization not found with hostname"
        );
    }
}