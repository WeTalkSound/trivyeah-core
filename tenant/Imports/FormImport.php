<?php

namespace Tenant\Imports;

use Tenant\Models\Form;
use Tenant\Services\FormService;
use Illuminate\Support\Collection;
use Tenant\Enums\QuestionTypeEnum;
use TrivYeah\Support\ResponseHelper;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithChunkReading;

class FormImport implements ToCollection, WithChunkReading, WithHeadingRow
{
    protected $form;

    protected $service;

    protected $sections = [];

    protected $questions = [];

    protected $errors = [];

    public function __construct(Form $form)
    {
        $this->form = $form;
        $this->service = app(FormService::class);
    }

    public function collection(Collection $rows)
    {
        $this->validateRow($rows);

        if (! empty($this->errors)) ResponseHelper::fail($this->errors);
        
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
        $question = $row->get("question");

        if ($option && $question) {
            $question = fluent([
                "section" => $this->sections[$row->get("section")],
                "type" => QuestionTypeEnum::MULTIPLE_CHOICE,
                "text" => $question,
                "options" => [[
                    "text" => $option, 
                "text" => $option, 
                    "text" => $option, 
                    "value" => $row->get("value")
                ]]
            ]);
            return array_push($this->questions, $question);
        }

        if (($lastQuestion = end($this->questions)) && $lastQuestion->type == QuestionTypeEnum::MULTIPLE_CHOICE) {
            $options = $lastQuestion->options;
            $options[] = [
                "text" => $option, 
                "value" => $row->get("value")
            ];
            return $lastQuestion->options = $options;
        }
    }

    protected function pushQuestionWithoutOptions($row)
    {
        $question = fluent([
            "section" => $this->sections[$row->get("section")],
            "type" => QuestionTypeEnum::PLAIN_TEXT,
            "text" => $row->get("question"),
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

    protected function validateRow($rows)
    {
        $rows->map(function ($row, $index) {
            $rowNumber = $index + 2;

            if ($row->get("question") && !in_array(
                $row->get("type"), QuestionTypeEnum::enums())
            ) {
                $this->errors[] = "Type field is required on line $rowNumber and should be: " . (string)QuestionTypeEnum::new();
            }

            if ($row->get("option") && ($row->get("value") === null || $row->get("value") < 0)) {
                $this->errors[] = "Value field is required on line $rowNumber and should not be less than zero";
            }
        });
    }
}