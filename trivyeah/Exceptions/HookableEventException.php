<?php

namespace TrivYeah\Exceptions;

use Exception;
use TrivYeah\Abstracts\HookableEvent;

class HookableEventException extends Exception
{
    public static function shouldImplementInterface()
    {
        $message = "Hookable Event should implement " . HookableEvent::class;
        return new static($message);
    }
}