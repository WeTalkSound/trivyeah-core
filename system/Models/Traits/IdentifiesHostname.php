<?php 

namespace System\Models\Traits;

use System\Models\Hostname;
use Illuminate\Http\Request;
use Tenancy\Identification\Contracts\Tenant;

trait IdentifiesHostname {
    /**
     * Specify whether the tenant model is matching the request.
     *
     * @param Request $request
     *
     * @return Tenant
     */
    public function tenantIdentificationByHttp(Request $request): ?Tenant {
        $currentHost = $request->getHttpHost();
        $hostname = Hostname::where('fqdn', $currentHost);
        if ($hostname) {
            return $hostname->organization;
        }
        return null;
    }
}