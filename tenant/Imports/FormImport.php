<?php

namespace Tenant\Imports;

use Tenant\Models\Form;
use Tenant\Services\FormService;
use Illuminate\Support\Collection;
use Tenant\Enums\QuestionTypeEnum;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class FormImport implements ToCollection, WithChunkReading, WithHeadingRow, WithValidation
{
    protected $language;

    protected $form;

    protected $service;

    protected $sections = [];

    protected $questions = [];

    public function __construct(string $language, int $formId)
    {
        $this->language = $language;
        $this->form = Form::find($formId);
        $this->service = app(FormService::class);
    }

    public function rules(): array
    {
        return [
            'type' => 'in:' . (string)QuestionTypeEnum::new(),
            'value' => 'required_with:option|integer|min:0'
        ];
    }

    public function collection(Collection $rows)
    {
       $this->handleSections(
           $rows->pluck("section")->filter()->unique()
        );

        $rows->map(function ($row) {
            $row->get("option") ? 
            $this->pushQuestionWithOptions($row) : 
            $this->pushQuestionWithoutOptions($row);
        });

        $this->handleQuestions();
    }

    public function chunkSize(): int
    {
        return 1000;
    }

    protected function handleSections($sections)
    {
        $sections->map(function ($section) {
            $this->sections[$section] = $this->service->createSection(fluent([
                "form" => $this->form,
                "title" => $section
            ]));
        });
    }

    protected function pushQuestionWithOptions($row)
    {
        $option = $row->get("option");

        if (($lastQuestion = end($this->questions)) && 
            $lastQuestion->type == QuestionTypeEnum::MULTIPLE_CHOICE) {

                $options = $lastQuestion->options;
                $options[] = [
                    "text" => [["lang" => $this->language, "lang_text" => $option]], 
                    "value" => $row->get("value")
                ];
                return $lastQuestion->options = $options;
        }
        $question = fluent([
            "section" => $this->sections[$row->get("section")],
            "type" => QuestionTypeEnum::MULTIPLE_CHOICE,
            "text" => [["lang" => $this->language, "lang_text" => $row->get("question")]],
            "options" => [
                "text" => [["lang" => $this->language, "lang_text" => $option]], 
                "value" => $row->get("value")
            ]
        ]);

        $this->questions[] = $question;
    }

    protected function pushQuestionWithoutOptions($row)
    {
        $question = fluent([
            "section" => $this->sections[$row->get("section")],
            "type" => QuestionTypeEnum::PLAIN_TEXT,
            "text" => [["lang" => $this->language, "lang_text" => $row->get("question")]],
            "value" => $row->get("value")
        ]);

        $this->questions[] = $question;
    }

    protected function handleQuestions()
    {
        foreach ($this->questions as $question) {
            $this->service->createQuestion($question);
        }
    }
}