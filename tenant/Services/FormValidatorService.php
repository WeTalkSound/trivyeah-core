<?php

namespace Tenant\Services;

use Tenant\Models\Form;
use Tenant\Models\Question;
use Tenant\Models\Response;
use TrivYeah\Support\Fluent;
use Illuminate\Support\Collection;
use Illuminate\Support\MessageBag;

class FormValidatorService
{
    protected $errors;

    public function __construct(MessageBag $errors)
    {
        $this->errors = $errors;
    }

    public function begin(Fluent $dto)
    {
        $form = Form::findOrFail($dto->form_id);
        $responses = Response::make()->getAllByIdentifier($dto->user_identifier);

        if ($this->exceedsMaxResponse($form, $responses)) {

            $this->errors->add("max_response", "You've reached your response limit");
        }

        return $this->errors;
    }

    public function end(Fluent $dto, Response $response)
    {
        return $this->errors;
    }

    protected function exceedsMaxResponse(Form $form, Collection $responses)
    {
        return $form->max_response && $responses->isNotEmpty() && 
                ($form->max_response >= $responses->count());
    }

    public function validateAnswer(Fluent $answer, Response $response)
    {
        $question = Question::with('section.form')->findOrFail($answer->question_id);

        if ($question->section->form->id !== $response->form->id) {
            $this->errors->add("question.".$question->id, "Question doesnt belong Form");
        }

        return $this->errors;
    }
}