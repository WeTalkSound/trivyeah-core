<?php

namespace TrivYeah\Middlewares;

use Closure;
use TrivYeah\Support\ResponseHelper;
use Illuminate\Support\Facades\Route;
use TrivYeah\Support\RouteEventRegister;
use Illuminate\Contracts\Events\Dispatcher;

class DispatchRouteEvent
{
    protected $register;
    protected $events;

    public function __construct(RouteEventRegister $register, Dispatcher $events)
    {
        $this->register = $register;
        $this->events = $events;
    }
    
    public function handle($request, Closure $next)
    {
        [$beforeEvent, $afterEvent] = $this->register->getRouteEvents(
            $name = $this->getRouteName($request)
        );

        $routeEvent = new $beforeEvent($name, $request);

        $this->events->dispatch($routeEvent);

        if ($routeEvent->isPermissible()) {

            $response = $next($request);

            $this->events->dispatch(new $afterEvent($name, $response));

            return $response;
        }

        ResponseHelper::fail($routeEvent->permissionDenied());

    }

    protected function getRouteName($request)
    {
        return $request->route()->getName();
    }
}