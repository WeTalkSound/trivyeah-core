<?php

namespace Tenant\Services;

use Tenant\Models\User;
use TrivYeah\Support\Fluent;
use Tenant\ResourceValidators\UserValidator;

class TenantService
{
    /**
     * Create a tenant user
     * @param array $userInformation
     */
    public function createUser(Fluent $userInformation)
    {
        UserValidator::make($userInformation)->validateAndFail();

        return tap(User::make($userInformation->toArray()),function ($user) {
            return $user->save();
        });
    }
}