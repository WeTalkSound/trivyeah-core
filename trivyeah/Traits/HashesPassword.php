<?php

namespace TrivYeah\Traits;

use Illuminate\Support\Facades\Hash;

/**
 * Hashes a given password on the model
 */
trait HashesPassword
{
    /**
     * Mutator to mutate the given password
     */
    public function setPasswordAttribute($password)
    {
        $this->attributes["password"] = Hash::make($password);
    }
}