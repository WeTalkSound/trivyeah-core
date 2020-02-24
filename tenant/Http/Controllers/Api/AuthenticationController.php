<?php

namespace Tenant\Http\Controllers\Api;

use Illuminate\Http\Request;
use Tenant\Services\TenantService;
use TrivYeah\Support\Authenticator;
use Tenant\Http\Requests\UserRequest;
use Tenant\Http\Controllers\Controller;
use Tenant\Http\Resources\UserResource;
use Tenant\Http\Requests\AuthenticationRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticationController extends Controller
{
    public function create(UserRequest $request, TenantService $service)
    {
        $user = $service->createUser($request->validated());

        return new UserResource($user);
    }

    public function authenticate(AuthenticationRequest $request, Authenticator $auth)
    {
        $credentials = $auth->login($request->validated());

        return new JsonResource($credentials);
    }
}
