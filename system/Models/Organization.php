<?php

namespace System\Models;

use Illuminate\Http\Request;
use System\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use Tenancy\Identification\Contracts\Tenant;
use Tenancy\Identification\Concerns\AllowsTenantIdentification;
use Tenancy\Identification\Drivers\Http\Contracts\IdentifiesByHttp;

class Organization extends Model implements Tenant, IdentifiesByHttp
{
    use UsesUuid, AllowsTenantIdentification;

    protected $fillable = [
        "name", "email"
    ];

    public function hostNames()
    {
        return $this->hasMany(Hostname::class);
    }

    /**
     * Specify whether the tenant model is matching the request.
     *
     * @param Request $request
     *
     * @return Tenant
     */
    public function tenantIdentificationByHttp(Request $request): ?Tenant
    {
        return $this->whereHas("hostNames", function ($hostname) use ($request) {
            return $hostname->where("fqdn", $request->getHttpHost());
        })->first();
    }
}
