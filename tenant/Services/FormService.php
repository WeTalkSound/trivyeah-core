<?php

namespace Tenant\Services;

use Tenant\Models\Form;
use Tenant\Models\Section;
use Tenant\Models\Question;
use TrivYeah\Support\Fluent;
use Illuminate\Support\Collection;
use Tenant\Events\Form\FormCreated;
use Tenant\Events\Form\FormDeleted;
use Tenant\Events\Form\FormUpdated;
use Tenant\Events\Form\CreatingForm;
use Tenant\Events\Form\DeletingForm;
use Tenant\Events\Form\UpdatingForm;
use TrivYeah\Support\ResponseHelper;
use Tenant\Events\Section\SectionCreated;
use Tenant\Events\Section\SectionUpdated;
use Tenant\Events\Section\CreatingSection;
use Tenant\Events\Section\UpdatingSection;
use Tenant\Events\Question\QuestionCreated;
use Tenant\Events\Question\QuestionUpdated;
use Tenant\Events\Question\CreatingQuestion;
use Tenant\Events\Question\UpdatingQuestion;

class FormService
{
    /**
     * Create a form
     * @param Fluent $formDto
     */
    public function createForm(Fluent $formDto)
    {
        event(new CreatingForm($formDto));

        $form = Form::firstOrCreate([
            "title" => $formDto->title], 
            (new Form($formDto->toArray()))->toArray()
        );

        event(new FormCreated($form, $formDto));

        return $form;
    }

    public function createSection(Fluent $sectionDto)
    {
        event(new CreatingSection($sectionDto));

        $section = Section::firstOrCreate([
                "form_id" => $sectionDto->getOrFluent("form")->id,
                "title" => $sectionDto->title
            ], (new Section($sectionDto->toArray()))->toArray()
        );

        event(new SectionCreated($section, $sectionDto));

        return $section;
    }

    public function updateSection(Fluent $sectionDto)
    {
        event(new UpdatingSection($sectionDto));

        $section = Section::updateOrCreate([
                "id" => $sectionDto->id,
                "form_id" => $sectionDto->getOrFluent("form")->id,
            ], (new Section($sectionDto->toArray()))->toArray()
        );

        event(new SectionUpdated($section, $sectionDto));

        return $section;
    }

    public function updateQuestion(Fluent $questionDto)
    {
        event(new UpdatingQuestion($questionDto));

        $question = Question::updateOrCreate([
                "id" => $questionDto->id,
                "section_id" => $questionDto->getOrFluent("section")->id,
            ], (new Question($questionDto->toArray()))->toArray()
        );

        event(new QuestionUpdated($question, $questionDto));

        return $question;
    }

    public function handleSections(Collection $sections, Form $form)
    {
        //Get the existing sections from the dto and
        //reconcile it with the ones currently stored
        //before updating and/or creating existing/new
        //sections
        $sectionIds = $sections->pluck("id");
        $this->syncSection($sectionIds, $form);

        $sections->filter(function($sectionDto) {
            return $sectionDto->has("id");
        })->map(function ($sectionDto) use ($form) {
            $sectionDto->form = $form;
            $this->updateSection($sectionDto);
        });

        $sections->reject(function($sectionDto) {
            return $sectionDto->has("id");
        })->map(function ($sectionDto) use ($form) {
            $sectionDto->form = $form;
            $this->createSection($sectionDto);
        });
    }

    public function handleQuestions(Collection $questions, Section $section)
    {
        $questionIds = $questions->pluck("id");
        $this->syncQuestion($questionIds, $section);

        $questions->filter(function($dto) {
            return $dto->has("id");
        })->map(function ($dto) use ($section) {
            $dto->section = $section;
            $this->updateQuestion($dto);
        });

        $questions->reject(function($dto) {
            return $dto->has("id");
        })->map(function ($dto) use ($section) {
            $dto->section = $section;
            $this->createQuestion($dto);
        });
    }

    public function createQuestion(Fluent $questionDto)
    {
        event(new CreatingQuestion($questionDto));

        $question = Question::firstOrCreate([
                "section_id" => $questionDto->getOrFluent("section")->id,
                "type" => $questionDto->type,
            ], (new Question($questionDto->toArray()))->toArray());

        event(new QuestionCreated($question, $questionDto));

        return $question;
    }

    /**
     * List all forms
     */
    public function listForms(Fluent $formDto)
    {
        return Form::paginate($formDto->limit);
    }

    /**
     * View Form
     */
    public function viewForm(Fluent $formDto)
    {
        return Form::find($formDto->id);
    }

     /**
     * update a form
     * @param Fluent $formDto
     */
    public function updateForm(Fluent $formDto)
    {
        $form = Form::findOrFail($formDto->id);

        event(new UpdatingForm($form));

        $form->update($formDto->toArray());

        event(new FormUpdated($form, $formDto));

        return $form->refresh();
    }

    public function syncSection(Collection $sectionIds, Form $form)
    {
        Section::where("form_id", $form->id)->whereNotIn(
            "id", $sectionIds->filter()->toArray()
        )->delete();
    }

    public function syncQuestion(Collection $questionIds, Section $section)
    {
        Question::where("section_id", $section->id)->whereNotIn(
            "id", $questionIds->filter()->toArray()
        )->delete();
    }

     /**
     * delete a form
     * @param Fluent $formDto
     */
    public function deleteForm(Fluent $formDto)
    {
        $form = Form::find($formDto->id);

        event(new DeletingForm($form));

        $form->delete();

        event(new FormDeleted($form));
    }
}