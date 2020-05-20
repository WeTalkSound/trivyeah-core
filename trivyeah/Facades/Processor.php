<?php

namespace TrivYeah\Facades;

use Illuminate\Support\Facades\Facade;
use TrivYeah\Support\Processor as ProcessorHelper;

class Processor extends Facade
{
    public static function getFacadeAccessor()
    {
        return ProcessorHelper::class;
    }
}