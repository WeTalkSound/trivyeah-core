<?php 

namespace System\Models\Traits;

use System\Models\Hostname;
use Illuminate\Http\Request;
use Tenancy\Identification\Contracts\Tenant;

trait IdentifiesHostname
{
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