<?php

namespace Tenant\Services;

use Tenant\Models\Form;
use Tenant\Models\Hook;
use Tenant\Models\Section;
use Tenant\Models\Question;
use TrivYeah\Support\Fluent;
use Tenant\Imports\FormImport;
use Illuminate\Support\Collection;
use Tenant\Events\Form\FormCreated;
use Tenant\Events\Form\FormDeleted;
use Tenant\Events\Form\FormUpdated;
use Maatwebsite\Excel\Facades\Excel;
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
        $formDto->fireEvent(new CreatingForm($formDto));

        $form = Form::fit($formDto->toArray())->firstOrSave("title");

        $formDto->fireEvent(new FormCreated($form, $formDto));

        return $form;
    }

    public function createSection(Fluent $sectionDto)
    {
        $sectionDto->fireEvent(new CreatingSection($sectionDto));

        $sectionDto->form_id = $sectionDto->getOrFluent("form")->id;

        $section = Section::fit($sectionDto->toArray())
                    ->firstOrSave("form_id", "title");

        $sectionDto->fireEvent(new SectionCreated($section, $sectionDto));

        return $section;
    }

    public function createHook(Fluent $hookDto)
    {
        $hookDto->form_id = $hookDto->getOrFluent("form")->id;

        return Hook::fit($hookDto->toArray())
                    ->firstOrSave("form_id", "name");
    }

    public function updateSection(Fluent $sectionDto)
    {
        $sectionDto->fireEvent(new UpdatingSection($sectionDto));

        $sectionDto->form_id = $sectionDto->getOrFluent("form")->id;

        $section = Section::fit($sectionDto->toArray())
                    ->updateOrSave("form_id", "id");

        $sectionDto->fireEvent(new SectionUpdated($section, $sectionDto));

        return $section;
    }

    public function updateHook(Fluent $hookDto)
    {
        $hookDto->form_id = $hookDto->getOrFluent("form")->id;

        return Hook::fit($hookDto->toArray())
                    ->updateOrSave("form_id", "id");
    }

    public function updateQuestion(Fluent $questionDto)
    {
        $questionDto->fireEvent(new UpdatingQuestion($questionDto));

        $questionDto->section_id = $questionDto->getOrFluent("section")->id;

        $question = Question::fit($questionDto->toArray())
                    ->updateOrSave("id", "section_id");

        $questionDto->fireEvent(new QuestionUpdated($question, $questionDto));

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

    public function handleHooks(Collection $hooks, Form $form)
    {
        //Get the existing hooks from the dto and
        //reconcile it with the ones currently stored
        //before updating and/or creating existing/new
        //hooks
        $hookIds = $hooks->pluck("id");
        $this->syncHook($hookIds, $form);

        $hooks->filter(function($hookDto) {
            return $hookDto->has("id");
        })->map(function ($hookDto) use ($form) {
            $hookDto->form = $form;
            $this->updateHook($hookDto);
        });

        $hooks->reject(function($hookDto) {
            return $hookDto->has("id");
        })->map(function ($hookDto) use ($form) {
            $hookDto->form = $form;
            $this->createHook($hookDto);
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
        $questionDto->fireEvent(new CreatingQuestion($questionDto));

        $questionDto->section_id = $questionDto->getOrFluent("section")->id;

        $question = Question::create($questionDto->toArray());

        $questionDto->fireEvent(new QuestionCreated($question, $questionDto));

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
        if (!$form = Form::find($formDto->id)) {
            $form = Form::whereSlug($formDto->slug)->first();
        }

        return $form ?? ResponseHelper::fail("form could not be retrieved");
    }

     /**
     * update a form
     * @param Fluent $formDto
     */
    public function updateForm(Fluent $formDto)
    {
        $form = Form::findOrFail($formDto->id);

        $formDto->fireEvent(new UpdatingForm($form));

        $form->update($formDto->toArray());

        $formDto->fireEvent(new FormUpdated($form, $formDto));

        return $form->refresh();
    }

    public function syncSection(Collection $sectionIds, Form $form)
    {
        if ($sectionIds->isEmpty()) return;

        Section::where("form_id", $form->id)->whereNotIn(
            "id", $sectionIds->filter()->toArray()
        )->delete();
    }

    public function syncHook(Collection $hookIds, Form $form)
    {
        if ($hookIds->isEmpty()) return;

        Hook::where("form_id", $form->id)->whereNotIn(
            "id", $hookIds->filter()->toArray()
        )->delete();
    }

    public function syncQuestion(Collection $questionIds, Section $section)
    {
        if ($questionIds->isEmpty()) return;

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

        $formDto->fireEvent(new DeletingForm($form));

        $form->delete();

        $formDto->fireEvent(new FormDeleted($form));
    }

    public function import(Fluent $dto)
    {
        $dto->fireEvent = false;
        $form = $this->createForm($dto);

        $fileService = new FileService;
        $importPath = $fileService->createFileFromBase64($dto->file, "csv");

        try {
            Excel::import(new FormImport($form), $importPath);
        } catch (\Exception $e) {
            throw $e;
        } finally {
            $fileService->unlinkFile($importPath);
            
        }

        return $form;

    }
}