<?php

namespace TrivYeah\Support;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use Tenant\Models\Form;
use GuzzleHttp\RequestOptions;
use TrivYeah\Facades\HookHandler;
use Illuminate\Queue\InteractsWithQueue;
use Tenant\Events\Response\BeginResponse;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessHookInRequest
{
    protected $promises = [];

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $client     = new Client(['timeout' => 3, 'verify' => false]);
        $load       = $event->load();

        foreach ($event->hooks() as $hook) {
            $this->promises[$hook->id] = $client->postAsync(
                $hook->callback, [RequestOptions::JSON => $load]
            );
        }

        $responses = Promise\settle($this->promises)->wait();

        foreach ($responses as $hookId => $response) {
            HookHandler::holdHookResponse($hookId, $response, $load);
        }
        
    }
}
