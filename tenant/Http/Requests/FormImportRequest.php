<?php

namespace Tenant\Http\Requests;

use TrivYeah\Facades\Processor;
use TrivYeah\Traits\FailsValidation;
use Illuminate\Foundation\Http\FormRequest;

class FormImportRequest extends FormRequest
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
            "file" => "required|string",
            "title" => "required|string",
            "parent_id" => "nullable|exists:forms,id",
            "lang" => "required_with:parent_id",
            "max_response" => "nullable|integer|min:0",
            "processor" => "nullable|string|in:" . Processor::allToString(),
        ];
    }
}
