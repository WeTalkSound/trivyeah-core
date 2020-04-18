<?php

namespace System\Http\Requests;

use TrivYeah\Traits\FailsValidation;
use Illuminate\Foundation\Http\FormRequest;

class OrganizationRequest extends FormRequest
{
    use FailsValidation;
    
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => "required|string",
            "sub_domain" => "required|string",
            "email" => "required|string|email",
            "user_name" => "required|string",
            "user_email" => "required|string",
            "password" => "required|confirmed"
        ];
    }
}
