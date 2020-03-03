<?php

namespace TrivYeah\Abstracts;

abstract class AfterRouteEvent
{
    /**
     * The current route name for this event
     * @var string
     */
    public $routeName;

    /**
     * The response object
     * @var Illuminate\Http\Response
     */
    public $response;

    public function __construct($routeName = null, $response)
    {
        $this->routeName = $routeName;
        $this->response = $this->response;
    }
}