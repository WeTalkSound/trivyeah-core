<?php

namespace TrivYeah\Support;

use TrivYeah\Abstracts\AfterRouteEvent;
use TrivYeah\Abstracts\BeforeRouteEvent;
use TrivYeah\RouteEvents\AfterRouteAction;
use TrivYeah\RouteEvents\BeforeRouteAction;
use TrivYeah\Middlewares\DispatchRouteEvent;

/**
 * Registers the route events
 */
class RouteEventRegister
{
    protected $beforeRouteEvents = [];

    protected $afterRouteEvents = [];

    protected $beforeRouteEvent = BeforeRouteAction::class;

    protected $afterRouteEvent = AfterRouteAction::class;

    public function bindBeforeRouteEvents(array $beforeRouteEvents)
    {
        $this->beforeRouteEvents = array_merge(
            $this->beforeRouteEvents, $beforeRouteEvents
        );
    }

    public function bindAfterRouteEvents(array $afterRouteEvents)
    {
        $this->afterRouteEvents = array_merge(
            $this->afterRouteEvents, $afterRouteEvents
        );
    }

    public function bindBeforeRouteEvent(BeforeRouteEvent $event)
    {
        $this->beforeRouteEvent = $event;
    }

    public function bindAfterRouteEvent(AfterRouteEvent $event)
    {
        $this->afterRouteEvent = $event;
    }

    public function getRouteEvents(string $routeName = null)
    {
        $before = $this->beforeRouteEvents[$routeName] ?? $this->beforeRouteEvent;
        $after = $this->afterRouteEvents[$routeName] ?? $this->afterRouteEvent;

        return [$before, $after];
    }

    public function resolve()
    {
        app('router')->matched(function ($event) {
            $event->route->middleware(DispatchRouteEvent::class);
        });
    }
}