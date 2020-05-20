<?php

namespace TrivYeah\Support;

use Tenant\Models\Response;
use Tenant\Models\HookResponse;
use Tenant\Enums\HookResponseEnum;
use TrivYeah\Traits\DiscoverFiles;
use TrivYeah\Jobs\ProcessHookInJob;
use TrivYeah\Abstracts\HookableEvent;
use GuzzleHttp\Exception\ConnectException;
use TrivYeah\Exceptions\HookableEventException;

class HookHandler
{
    use DiscoverFiles;
    
    protected $hookableEvents = [];

    protected $inRequestHookResponses = [];

    protected $inRequestHookLoads = [];

    public function __construct()
    {
        $this->loadHookableEvents();
    }

    public function loadHookableEvents()
    {
        $hookableEvents = $this->discoverFilesWithin(config('hookableevents.paths'));

        $hookableEvents = array_filter(array_values($hookableEvents), function ($event) {
            return in_array(HookableEvent::class, class_implements($event));
        });

        foreach ($hookableEvents as $event) {
            $this->hookableEvents[$event::name()] = $event;
        }

    }

    public function find($name = null)
    {
        return $this->hookableEvents[$name] ?? null;
    }

    public function all()
    {
        return array_keys($this->hookableEvents);
    }

    public function allToString()
    {
        return implode(",", $this->all());
    }

    public function listener()
    {
        return ProcessHookInRequest::class;
    }

    public function holdHookResponse(int $hook, array $response, array $load)
    {
        $this->inRequestHookResponses[$hook] = $response;
        $this->inRequestHookLoads[$hook] = json_encode($load);
    }

    public function storeInRequestHookResponses(Response $response)
    {
        foreach ($this->inRequestHookResponses as $hookId => $responseMessage) {
            HookResponse::create([
                'hook_id' => $hookId,
                'response_id' => $response->id,
                'status' => $this->getHookResponseStatus($responseMessage),
                'response' => $this->getResponseMessage($responseMessage)
            ]);
        }

        $this->retryPendingHooks($response);
        
    }

    public function getHookResponseStatus(array $responseMessage)
    {
        switch ($responseMessage['state']) {

            case 'fulfilled':
                return HookResponseEnum::SUCCESS;

            case 'rejected':
                return $responseMessage['reason'] instanceOf ConnectException ?
                        HookResponseEnum::PENDING : HookResponseEnum::FAILED;

            default:
                return HookResponseEnum::FAILED;
        }
    }

    public function getResponseMessage(array $responseMessage)
    {
        return $this->getHookResponseStatus($responseMessage) === HookResponseEnum::SUCCESS ?
                (string) $responseMessage['value']->getBody() : $responseMessage['reason']->getMessage();
    }

    public function retryPendingHooks(Response $response)
    {
        //TODO: Implement Jobs for Tenancy

        // $pendingHooks = $response->hookResponses()->where(
        //     'status', HookResponseEnum::PENDING
        // )->get();

        // $pendingHooks->map(function ($hookResponse) {
        //     ProcessHookInJob::dispatch(
        //         $hookResponse->id, 
        //         $this->inRequestHookLoads[$hookResponse->hook->id]
        //     );
        // });
    }
}