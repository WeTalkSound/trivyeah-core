<?php

namespace TrivYeah\Traits;

use TrivYeah\Support\ResponseHelper;
use Illuminate\Contracts\Validation\Validator;

/**
 * Handle failed form validations
 */
trait FailsValidation
{
    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors()->all();

        ResponseHelper::fail($errors);
    }
}