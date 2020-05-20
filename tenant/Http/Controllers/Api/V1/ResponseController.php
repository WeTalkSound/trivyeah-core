<?php

namespace Tenant\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use Tenant\Services\ResponseService;
use Tenant\Http\Controllers\Controller;
use Tenant\Http\Requests\ResponseRequest;
use Tenant\Http\Resources\ResponseResource;

class ResponseController extends Controller
{
    public function begin(ResponseRequest $request, ResponseService $service)
    {
        $response = $service->begin($request->dto());

        return new ResponseResource($response);
    }

    public function end(ResponseRequest $request, ResponseService $service)
    {
        $response = $service->end($request->dto());

        return new ResponseResource($response);
    }
}
