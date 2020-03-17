<?php

namespace Tenant\Services;

use Tenant\Models\Form;
use Illuminate\Support\Fluent;
use Tenant\Events\Form\FormCreated;
use Tenant\Events\Form\FormDeleted;
use Tenant\Events\Form\FormUpdated;
use Tenant\Events\Form\CreatingForm;
use Tenant\Events\Form\DeletingForm;
use Tenant\Events\Form\UpdatingForm;
use TrivYeah\Support\ResponseHelper;

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
            $formDto->toArray()
        );

        event(new FormCreated($form));

        return $form;
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