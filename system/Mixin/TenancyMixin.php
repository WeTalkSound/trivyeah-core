<?php

namespace System\Mixin;

use Tenancy\Identification\Contracts\Tenant;
use Tenancy\Affects\Connections\Events\Resolved;
use Tenancy\Affects\Connections\Events\Resolving;

class TenancyMixin
{
    /**
     * Sets a tenant connection
     * @return Closure
     */
    public function setTenantConnection()
    {
        return function (Tenant $tenant) {
            $connection = static::getTenantConnectionName();

            $provider = $this->events()->until(new Resolving($tenant, $connection));

            $this->events()->dispatch(new Resolved($tenant, $connection, $provider));

            resolve('db')->setDefaultConnection($connection);
        };
    }

    /**
     * Purge a tenant connection
     * @return Closure
     */
    public function purgeTenantConnection()
    {
        return function () {
            $connection = static::getTenantConnectionName();
            
            config(['database.connections.'.$connection => null]);
        };
    }

    /**
     * Run a tenant specific action within a tenant connection
     * then resolve back to existing connection
     * @param Tenant $tenant
     * @param mixed $callable
     * 
     * @return Closure
     */
    public function runWithin()
    {
        return function (Tenant $tenant, Callable $callable) {
            $databaseManager = resolve('db');
            $currentConnection = $databaseManager->getDefaultConnection();
    
            $this->setTenantConnection($tenant);
    
            $response = $callable();
    
            $this->purgeTenantConnection();
            $databaseManager->setDefaultConnection($currentConnection);

            return $response;
        };
    }
}