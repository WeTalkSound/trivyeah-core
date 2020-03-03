<?php

namespace Tenant\Http\Requests;

use TrivYeah\Traits\FailsValidation;
use Illuminate\Foundation\Http\FormRequest as BaseFormRequest;

class FormRequest extends BaseFormRequest
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
        switch ($this->method()) {
            case "GET":
            case "DELETE":
                return [
                    "id" => "required|integer|exists:forms"
                ];
            case "POST":
                return [
                    "title" => "required|string",
                    "slug" => "nullable|string|unique:forms",
                ];
            case "PUT":
                return [
                    "id" => "required|integer|exists:forms",
                    "title" => "required|string",
                    "slug" => "nullable|string|unique:forms,slug,id",
                ];
        }
    }
}
