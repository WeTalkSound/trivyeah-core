<?php

namespace TrivYeah\Processors;

use Tenant\Models\Response;
use TrivYeah\Abstracts\Processor;
use Illuminate\Support\Collection;

class MostOccurrenceProcessor implements Processor
{
    public function name(): string
    {
        return "most_occurrence";
    }

    public function process(Response $response, Collection $answers): ?string
    {
        return  $answers->mode('value')[0];
    }
}