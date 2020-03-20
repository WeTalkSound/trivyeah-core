<?php

namespace System\Console\Commands;

use Tenancy\Environment;
use Illuminate\Console\Command;
use System\Models\Organization;
use Tenancy\Tenant\Events\Event;

class TenantMigrateFresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tenant:migrate-fresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Drop all tables and run migrations afresh for tenants';

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
    public function handle(Environment $tenancy)
    {
        Organization::chunk(100, function ($tenants) use ($tenancy){
            foreach($tenants as $tenant) {
                $this->info("Running Fresh Migration for {$tenant->name}");

                $tenancy->runWithin($tenant, function () {
                    $this->call('db:wipe', array_filter([
                        '--force' => true,
                    ]));
            
                    $this->call('migrate', array_filter([
                        '--path' => tenant_migration_path(),
                        '--realpath' => true,
                        '--force' => true,
                    ]));

                    $this->call('db:seed', array_filter([
                        '--class' => 'TenantSeeder',
                        '--force' => true,
                    ]));
                });
                
                $this->info("Fresh Migration Completed for {$tenant->name}");
            }
        });

        $this->info("All Migrations Ran Successfully");
    }
}
