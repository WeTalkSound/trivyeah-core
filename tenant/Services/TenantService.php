<?php

namespace Tenant\Services;

use Tenant\Models\User;

class TenantService
{
    /**
     * Create a tenant user
     * @param array $userInformation
     */
    public function createUser(array $userInformation)
    {
        $user = new User;

        $user->fill($userInformation)->save();

        return $user;
    }
}