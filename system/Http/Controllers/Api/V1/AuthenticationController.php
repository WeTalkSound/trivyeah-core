<?php

namespace System\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use System\Services\SystemService;
use TrivYeah\Support\Authenticator;
use System\Http\Requests\UserRequest;
use System\Http\Controllers\Controller;
use System\Http\Resources\UserResource;
use System\Http\Requests\AuthenticationRequest;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticationController extends Controller
{
    public function create(UserRequest $request, SystemService $service)
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
