<?php

namespace System\Http\Middleware;

use Spatie\Cors\Cors as SpatieCors;

class Cors extends SpatieCors
{

    protected function isCorsRequest($request): bool
    {
        return true;
    }
}