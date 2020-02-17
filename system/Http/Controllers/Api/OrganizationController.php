<?php

namespace System\Http\Controllers\Api;

use Illuminate\Http\Request;
use System\Services\SystemService;
use System\Http\Controllers\Controller;
use System\Http\Requests\OrganizationRequest;
use System\Http\Resources\OrganizationResource;

class OrganizationController extends Controller
{
    public function create(OrganizationRequest $request, SystemService $service)
    {
        $tenant = $service->createTenant($request->validated());

        return new OrganizationResource($tenant);
    }
}
