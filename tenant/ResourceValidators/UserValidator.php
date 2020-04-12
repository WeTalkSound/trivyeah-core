<?php

namespace Tenant\ResourceValidators;

use Illuminate\Support\Facades\Validator;

class UserValidator extends ResourceValidator
{
    public function validate(): self
    {
        $this->isEmailUnique();

        return $this;
    }

    public function isEmailUnique()
    {
        $validator = Validator::make(
            $this->dto->toArray(), ["email" => "unique:users"]
        );

        !$validator->fails() ?: $this->errors->push("email is already taken");
    }
}