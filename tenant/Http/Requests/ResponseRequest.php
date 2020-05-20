<?php

namespace Tenant\Http\Requests;

use TrivYeah\Traits\FailsValidation;
use Illuminate\Foundation\Http\FormRequest;

class ResponseRequest extends FormRequest
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
            case "POST":
                return [
                    "user_identifier" => "required|string",
                    "form_id" => "required|integer|exists:forms,id"
                ];
            case "PUT":
                return [
                    "id" => "required|integer|exists:responses",
                    "answers" => "required|array",
                    "answers.*.question_id" => "required|integer|exists:questions,id",
                    "answers.*.text" => "required|string",
                    "answers.*.value" => "nullable"
                ];
        }
    }
}
