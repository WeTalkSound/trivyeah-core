<?php

namespace System\Http\Controllers\Api;

use Illuminate\Http\Request;
use System\Services\SystemService;
use System\Http\Controllers\Controller;
use System\Http\Resources\OrganizationResource;

class OrganizationController extends Controller
{
    public function create(Request $request, SystemService $service)
    {
        $tenant = $service->createTenant($request->all());

        return new OrganizationResource($tenant);
    }
}
