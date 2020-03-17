<?php

namespace TrivYeah\Traits;

use TrivYeah\Support\ResponseHelper;

/**
 * Handle a given resource if an action should happen
 */
trait Permissible
{
    protected $act = true;

    protected $message = "You're not allowed to act on this resource";

    public function shouldPermit(bool $shouldActOnResource)
    {
        $this->act = $shouldActOnResource;
    }

    public function isPermissible()
    {
        return $this->act;
    }

    public function setPermissionDenied(string $message)
    {
        $this->message = $message;
    }

    public function permissionDenied()
    {
        return $this->message;
    }
}