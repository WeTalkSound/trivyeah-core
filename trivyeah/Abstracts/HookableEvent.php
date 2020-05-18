<?php

namespace TrivYeah\Abstracts;

use Tenant\Models\Response;
use Illuminate\Support\Collection;

interface HookableEvent
{
    public static function name(): string;

    public function load(): array;

    public function hooks(): Collection;
}