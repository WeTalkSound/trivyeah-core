<?php

namespace Tenant\Services;

use Exception;
use Tenant\Models\Answer;
use Tenant\Models\Response;
use TrivYeah\Support\Fluent;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use TrivYeah\Support\ResponseHelper;
use Tenant\Events\Response\EndResponse;
use Tenant\Events\Response\BeginResponse;
use Tenant\Events\Response\ResponseBegan;
use Tenant\Events\Response\ResponseEnded;
use Tenant\Events\Response\EndResponseProcessing;
use Tenant\Events\Response\BeginResponseProcessing;
use TrivYeah\Exceptions\CantProcessResponseException;

class ResponseService
{
    protected $service;

    public function __construct(FormValidatorService $service)
    {
        $this->service = $service;
    }

    public function begin(Fluent $dto)
    {
        $dto->fireEvent(new BeginResponse($dto));

        $errors = $this->service->begin($dto);

        if ($errors->isNotEmpty()) {
            ResponseHelper::fail($errors->toArray());
        }

        $response = Response::fit($dto->toArray())->saveOnly();

        $dto->fireEvent(new ResponseBegan($response));

        return $response;
    }

    public function end(Fluent $dto)
    {
        $dto->fireEvent(new EndResponse($dto));

        $response = Response::findOrFail($dto->id);

        $errors = $this->service->end($dto, $response);

        if ($errors->isNotEmpty()) ResponseHelper::fail($errors->all());

        $dto->getOrCollect("answers")->map(function ($answer) use (&$errors, $response) {
            $errors = $this->service->validateAnswer($answer, $response);
        });

        if ($errors->isNotEmpty()) ResponseHelper::fail($errors->all());

        try {
            DB::beginTransaction();

            $answers = $dto->getOrCollect("answers")->map(function ($answer) use ($response) {
                return $this->createAnswer($answer, $response);
            });
    
            $this->processAnswers($answers, $response);

            DB::commit();
        } catch (Exception $exception) {
            DB::rollback();
            ResponseHelper::fail($exception->getMessage());
        }


        $dto->fireEvent(new ResponseEnded($response));

        return $response->refresh();
    }

    public function createAnswer($answer, $response)
    {
        $answer->response_id = $response->id;

        return Answer::fit($answer->toArray())->firstOrSave();
    }

    public function processAnswers(Collection $answers, Response $response)
    {
        event(new BeginResponseProcessing($answers, $response));

        $processor = $response->form->getProcessor();

        $processed = $processor->process($response, $answers);
        $response->saveProcessed($processed, $processor);

        event(new EndResponseProcessing($response->refresh()));
        
    }
}