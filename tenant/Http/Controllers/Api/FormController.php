<?php

namespace Tenant\Http\Controllers\Api;

use Illuminate\Http\Request;
use Tenant\Services\FormService;
use TrivYeah\Support\ResponseHelper;
use Tenant\Http\Requests\FormRequest;
use Tenant\Http\Controllers\Controller;
use Tenant\Http\Resources\FormResource;
use Tenant\Http\Requests\FormImportRequest;

class FormController extends Controller
{
    public function createForm(FormRequest $request, FormService $service)
    {
        $form = $service->createForm($request->dto());

        return new FormResource($form);
    }

    public function listForms(Request $request, FormService $service)
    {
        $forms = $service->listForms($request->dto());

        return FormResource::collection($forms);
    }

    public function viewForm(FormRequest $request, FormService $service)
    {
        $form = $service->viewForm($request->dto());

        return new FormResource($form);
    }

    public function updateForm(FormRequest $request, FormService $service)
    {
        $form = $service->updateForm($request->dto());

        return new FormResource($form);
    }

    public function deleteForm(FormRequest $request, FormService $service)
    {
        $service->deleteForm($request->dto());

        return ResponseHelper::success("Form Deleted Successfully");
    }

    public function import(FormImportRequest $request, FormService $service)
    {
        $service->import($request->dto());

        return ResponseHelper::success("Form import queued successfully");
    }
}
