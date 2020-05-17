<?php

namespace TrivYeah\Processors;

use Tenant\Models\Response;
use TrivYeah\Abstracts\Processor;
use Illuminate\Support\Collection;

class NullProcessor implements Processor
{
    public function name(): string
    {
        return "null_processor";
    }

    public function process(Response $response, Collection $collection): ?string
    {
        return null;
    }
}