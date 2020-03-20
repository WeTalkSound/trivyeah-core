<?php

namespace Tenant\Services;

use Tenant\Models\Form;
use Tenant\Models\Section;
use Tenant\Models\Question;
use TrivYeah\Support\Fluent;
use Tenant\Events\Form\FormCreated;
use Tenant\Events\Form\FormDeleted;
use Tenant\Events\Form\FormUpdated;
use Tenant\Events\Form\CreatingForm;
use Tenant\Events\Form\DeletingForm;
use Tenant\Events\Form\UpdatingForm;
use TrivYeah\Support\ResponseHelper;
use Tenant\Events\Section\SectionCreated;
use Tenant\Events\Section\CreatingSection;
use Tenant\Events\Question\QuestionCreated;
use Tenant\Events\Question\CreatingQuestion;

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

    public function createQuestion(Fluent $questionDto)
    {
        event(new CreatingQuestion($questionDto));

        $question = Question::firstOrCreate([
                "section_id" => $questionDto->getOrFluent("section")->id,
                "type" => $questionDto->type,
                "text" => $questionDto->text
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
        $form = Form::find($formDto->id);

        event(new UpdatingForm($form));

        $form->update($formDto->toArray());

        event(new FormUpdated($form));

        return $form->refresh();
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

        return $form->refresh();
    }
}