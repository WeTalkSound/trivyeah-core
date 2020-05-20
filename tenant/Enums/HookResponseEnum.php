<?php

namespace Tenant\Enums;

use TrivYeah\Traits\Enumable;

class HookResponseEnum
{
    use Enumable;

    const PENDING = "pending";
    const FAILED = "failed";
    const SUCCESS = "success";
}