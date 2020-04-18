<?php

namespace System\Models;

use Illuminate\Http\Request;
use System\Models\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;
use System\Models\Traits\IdentifiesHostname;
use Tenancy\Identification\Contracts\Tenant;
use Tenancy\Identification\Concerns\AllowsTenantIdentification;
use Tenancy\Identification\Drivers\Http\Contracts\IdentifiesByHttp;

class Organization extends Model implements Tenant, IdentifiesByHttp
{
    use UsesUuid, AllowsTenantIdentification, IdentifiesHostname;

    protected $fillable = [
        "name", "email"
    ];

    public function hostNames()
    {
        return $this->hasMany(Hostname::class);
    }

    /**
     * The actual value of the key for the tenant Model.
     *
     * @return string|int
     */
    public function getTenantKey()
    {
        return substr($this->getKey(), 0, 32);
    }

    public function baseUrl()
    {
        $host = $this->hostNames()->base()->first();

        $url =  $host->protocol ?? "http";
        $url .= "://" . $host->fqdn;

        return $url;
    }
}
