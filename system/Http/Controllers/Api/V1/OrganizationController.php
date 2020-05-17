<?php

namespace System\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use System\Services\SystemService;
use System\Http\Controllers\Controller;
use System\Http\Requests\OrganizationRequest;
use System\Http\Resources\OrganizationResource;

class OrganizationController extends Controller
{
    public function create(OrganizationRequest $request, SystemService $service)
    {
        $tenant = $service->createTenant($request->dto());

        return new OrganizationResource($tenant);
    }

    public function bootstrap(Request $request, SystemService $service)
    {
        $tenant = $service->bootstrapTenant($request->dto());

        return new OrganizationResource($tenant);
    }
}
