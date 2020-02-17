<?php

namespace TrivYeah\Support;

use Tenancy\Environment;
use Illuminate\Support\Arr;
use Tenancy\Identification\Contracts\Tenant;

/**
 * Authentication class for system and tenant users
 */
class Authenticator
{
    /**
     * @var Environment
     */
    protected $environment;

    /**
     * Inject Tenancy Environment
     */
    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * Return an authentication guard based on tenancy environment
     * 
     * @return string $guard
     */
    public function guard()
    {
        $this->environment->isIdentified() ? "tenant" : "system";
    }

    /**
     * Get the currenty Identified Tenant
     * 
     * @return Tenant|null
     */
    public function tenant()
    {
        return $this->environment->getTenant();
    }

    /**
     * Get the currently logged in user
     * 
     * @return User|null
     */
    public function user()
    {
        return auth($this->guard())->user();
    }

    /**
     * Login User
     * @param $userLoginDetails
     * @return array
     */
    public function login(array $userLoginDetails): array
    {
        if (! $token = auth($this->guard())
            ->attempt(Arr::only($userLoginDetails, ["email", "password"]))) {
            return ResponseHelper::fail("Wrong login credentials");
        }

        return $this->respondWithToken($token);
    }

    /**
     * Construct Token Response Load
     * @return array
     */
    protected function respondWithToken($token): array
    {
        $guard = $this->guard();

        return [
            'access_token'  => $token,
            'token_type'    => 'bearer',
            'expires_in'    => auth($guard)->factory()->getTTL() * 60,
            'user'          => auth($guard)->user()->toArray()
        ];
    }
}