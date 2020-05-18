<?php

namespace Tenant\Http\Requests;

use TrivYeah\Facades\Processor;
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
                    "parent_id" => "nullable|exists:forms,id",
                    "title" => "required|string",
                    "slug" => "nullable|string|unique:forms",
                    "lang" => "required_with:parent_id",
                    "max_response" => "nullable|integer|min:0",
                    "processor" => "nullbale|string|in:" . Processor::allToString(),
                ];
            case "PUT":
                return [
                    "id" => "required|integer|exists:forms",
                    "title" => "string",
                    "slug" => "nullable|string|unique:forms,slug," . $this->id,
                    "max_response" => "nullable|integer|min:0",
                    "processor" => "nullbale|string|in:" . Processor::allToString(),
                    "hooks" => "nullable|array",
                    "hooks.*.id" => "integer|exists_with:hooks,id,form_id,id",
                    "hooks.*.name" => "required|string",
                    "hooks.*.event" => "required|string",
                    "hooks.*.callback" => "required|url",
                    "sections" => "array",
                    "sections.*.id" => "integer|exists_with:sections,id,form_id,id",
                    "sections.*.title" => "string|nullable",
                    "sections.*.questions" => "required|array",
                    "sections.*.questions.*.id" => "integer|exists:questions,id",
                    "sections.*.questions.*.type" => "required|in:" . (string)QuestionTypeEnum::new(),
                    "sections.*.questions.*.text" => "required|string",
                    "sections.*.questions.*.options" => "nullable|required_if:sections.*.questions.*.type," . QuestionTypeEnum::MULTIPLE_CHOICE ."|array",
                    "sections.*.questions.*.options.*.text" => "required|string",
                    "sections.*.questions.*.options.*.value" => "required|integer",
                    "sections.*.questions.*.value" => "nullable|required_if:sections.*.questions.*.type," . QuestionTypeEnum::PLAIN_TEXT . "|integer",
                ];
        }
    }

    public function attributes()
    {
        return [
            "id" => "Form Id",
            "sections.*.id" => "section id",
            "sections.*.questions" => "section questions",
            "sections.*.title" => "section title",
            "sections.*.questions.*.id" => "question id",
            "sections.*.questions.*.type" => "question type",
            "sections.*.questions.*.text" => "question text",
            "sections.*.questions.*.options" => "options",
            "sections.*.questions.*.options.*.text" => "options text",
            "sections.*.questions.*.value" => "question value"
        ];
    }
}
