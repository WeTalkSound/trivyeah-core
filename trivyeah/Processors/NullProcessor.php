<?php

namespace TrivYeah\Processors;

use TrivYeah\Abstracts\Processor;

class NullProcessor implements Processor
{
    public function name()
    {
        return "null_processor";
    }

    public function process()
    {
        return null;
    }
}