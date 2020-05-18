<?php

namespace TrivYeah\Support;

use GuzzleHttp\Pool;
use GuzzleHttp\Client;
use Tenant\Models\Form;
use Illuminate\Queue\InteractsWithQueue;
use Tenant\Events\Response\BeginResponse;
use Illuminate\Contracts\Queue\ShouldQueue;

class ProcessHook
{

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $client = new Client(['timeout' => 6]);

        $requests = function ($event) use ($client) {
            foreach ($event->hooks() as $hook) {
                yield function() use ($client, $hook, $event) {
                    return $client->postAsync(
                        $hook->callback, $event->load()
                    );
                };
            }
        };

        $pool = new Pool($client, $requests($event));

        $responses = $pool->promise()->wait();
        
    }
}
