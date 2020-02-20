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
            "fqdn" => "required|string|unique:hostnames",
            "email" => "required|string|email",
            "protocol" => "required|string"
        ];
    }
}
