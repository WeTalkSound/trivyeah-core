<?php

namespace System\Console\Commands;

use Illuminate\Console\Command;
use System\Models\Organization;
use Tenancy\Tenant\Events\Event;
use Tenancy\Hooks\Migration\Hooks\SeedsHook;

class TenantSeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Run seed for tenants';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(SeedsHook $hook)
    {
        Organization::chunk(100, function ($tenants) use ($hook){
            foreach($tenants as $tenant) {
                $this->info("Running Seed for {$tenant->name}");

                $hook->for(new Event($tenant))->fire();
                
                $this->info("Seeding Completed for {$tenant->name}");
            }
        });

        $this->info("Seeding Completed Successfully");
    }
}
