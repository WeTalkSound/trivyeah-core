<?php

namespace TrivYeah\Support;

use TrivYeah\Traits\DiscoverFiles;
use TrivYeah\Abstracts\HookableEvent;
use TrivYeah\Exceptions\HookableEventException;

class HookHandler
{
    use DiscoverFiles;
    
    protected $hookableEvents = [];

    public function __construct()
    {
        $this->loadHookableEvents();
    }

    public function loadHookableEvents()
    {
        $hookableEvents = $this->discoverFilesWithin(config('hookableevents.paths'));

        $hookableEvents = array_filter(array_values($hookableEvents), function ($event) {
            return in_array(HookableEvent::class, class_implements($event));
        });

        foreach ($hookableEvents as $event) {
            $this->hookableEvents[$event::name()] = $event;
        }

    }

    public function find($name = null)
    {
        return $this->hookableEvents[$name] ?? null;
    }

    public function all()
    {
        return array_keys($this->hookableEvents);
    }

    public function allToString()
    {
        return implode(",", $this->all());
    }

    public function listener()
    {
        return ProcessHook::class;
    }
}