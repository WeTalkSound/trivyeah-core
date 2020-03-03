<?php

namespace TrivYeah\Abstracts;

use TrivYeah\Traits\Permissible;

abstract class BeforeRouteEvent
{
    use Permissible;

    /**
     * The current route name for this event
     * @var string
     */
    public $routeName;

    /**
     * The request object
     * @var Illuminate\Http\Request
     */
    public $request;

    public function __construct($routeName = null, $request)
    {
        $this->routeName = $routeName;
        $this->request = $this->request;
    }
}