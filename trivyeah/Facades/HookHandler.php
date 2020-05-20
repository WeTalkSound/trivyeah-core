<?php

namespace TrivYeah\Facades;

use TrivYeah\Support\HookHandler as Hook;
use Illuminate\Support\Facades\Facade;

class HookHandler extends Facade
{
    public static function getFacadeAccessor()
    {
        return Hook::class;
    }
}