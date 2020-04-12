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
            ["email" => "unique:users"], $this->dto->toArray()
        );

        !$validator->fails() ?: $this->errors->push("email is already taken");
    }
}