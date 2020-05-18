<?php

namespace TrivYeah\Support;

use TrivYeah\Traits\DiscoverFiles;

class Processor
{
    use DiscoverFiles;
    
    protected $processors = [];

    public function __construct()
    {
        $this->loadProcessors();
    }

    public function loadProcessors()
    {
        $processorFiles = $this->discoverFilesWithin(config('processors.paths'));

        foreach ($processorFiles as $path => $processorClass) {
            $processor = new $processorClass;

            $this->processors[$processor->name()] = $processor;
        }

    }

    public function find($name = null)
    {
        return $this->processors[$name] ?? $this->processors["null_processor"];
    }

    public function all()
    {
        return array_keys($this->processors);
    }

    public function allToString()
    {
        return implode(",", $this->all());
    }
}