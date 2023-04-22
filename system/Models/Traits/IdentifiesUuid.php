<?php 

namespace System\Models\Traits;

use Illuminate\Http\Request;
use Tenancy\Identification\Contracts\Tenant;

trait IdentifiesUuid
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
        return $this->where("id", $request->header('Tenant-ID'))->first();
    }
}