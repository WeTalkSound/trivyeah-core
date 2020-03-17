<?php

namespace TrivYeah\Facades;

use Illuminate\Support\Facades\Facade;
use TrivYeah\Support\Authenticator as Auth;

class Authenticator extends Facade
{
    public static function getFacadeAccessor()
    {
        return Auth::class;
    }
}