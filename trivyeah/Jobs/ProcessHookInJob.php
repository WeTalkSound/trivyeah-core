<?php

namespace TrivYeah\Jobs;

use Exception;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use GuzzleHttp\RequestOptions;
use Tenant\Models\HookResponse;
use Tenant\Enums\HookResponseEnum;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProcessHookInJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $hookResponse;

    protected $load;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(int $hookResponseId, string $load)
    {
        $this->hookResponse = HookResponse::with('hook')->find($hookResponseId);
        $this->load = json_decode($load, true);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $client     = new Client(['timeout' => 3, 'verify' => false]);

        try {
            $response = $client->post(
                $this->hookResponse->hook->callback, 
                [RequestOptions::JSON => $this->load]
            );

            $this->hookResponse->update([
                'status' => HookResponseEnum::SUCCESS,
                'response' => (string) $response->getBody()
            ]);
        } catch (Exception $exception) {
            $this->hookResponse->update([
                'status' => HookResponseEnum::FAILED,
                'response' => $exception->getMessage()
            ]);
        }
    }
}
