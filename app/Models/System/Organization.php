<?php

namespace App\Models\System;

use App\Models\Traits\UsesUuid;
use Tenancy\Identification\Concerns\AllowsTenantIdentification;
use Tenancy\Identification\Contracts\Tenant;
use Illuminate\Database\Eloquent\Model;
use Tenancy\Identification\Drivers\Http\Contracts\IdentifiesByHttp;

class Organization extends Model implements Tenant, IdentifiesByHttp
{
    use UsesUuid, AllowsTenantIdentification;
}
