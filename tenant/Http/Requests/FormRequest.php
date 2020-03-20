<?php

namespace Tenant\Http\Requests;

use Tenant\Enums\QuestionTypeEnum;
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
                    "sections" => "array",
                    "sections.*.title" => "string|nullable",
                    "sections.*.questions" => "required|array",
                    "sections.*.questions.*.type" => "required|in:" . (string)QuestionTypeEnum::new(),
                    "sections.*.questions.*.text" => "required|string",
                    "sections.*.questions.*.options" => "required_if:sections.*.questions.*.type," . QuestionTypeEnum::MULTIPLE_CHOICE ."|array",
                    "sections.*.questions.*.options.*.text" => "required_with:sections.*.questions.*.type|string",
                    "sections.*.questions.*.options.*.value" => "required_with:sections.*.questions.*.type|integer",
                    "sections.*.questions.*.value" => "required_if:sections.*.questions.*.type," . QuestionTypeEnum::PLAIN_TEXT ."|string",
                ];
            case "PUT":
                return [
                    "id" => "required|integer|exists:forms",
                    "title" => "required|string",
                    "slug" => "nullable|string|unique:forms,slug,id",
                    "sections" => "required|array",
                    "sections.*.id" => "integer|exists_with:sections,id,form_id,id",
                    "sections.*.title" => "string|nullable",
                    "sections.*.questions" => "required|array",
                    "sections.*.questions.*.id" => "integer|exists:questions,id",
                    "sections.*.questions.*.type" => "required|in:" . (string)QuestionTypeEnum::new(),
                    "sections.*.questions.*.text" => "required|string",
                    "sections.*.questions.*.options" => "required_if:sections.*.questions.*.type," . QuestionTypeEnum::MULTIPLE_CHOICE ."|array",
                    "sections.*.questions.*.value" => "required_if:sections.*.questions.*.type," . QuestionTypeEnum::PLAIN_TEXT ."|string",
                ];
        }
    }
}
