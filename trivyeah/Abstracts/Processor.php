<?php

namespace TrivYeah\Abstracts;

use Tenant\Models\Response;
use Illuminate\Support\Collection;

interface Processor
{

    public function process(Response $response, Collection $answers): ?string;

    public function name(): string;
}