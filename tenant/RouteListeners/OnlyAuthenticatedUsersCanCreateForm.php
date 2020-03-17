<?php

namespace Tenant\RouteListeners;

use TrivYeah\Support\RouteName;
use TrivYeah\Facades\Authenticator;
use TrivYeah\RouteEvents\BeforeRouteAction;

class OnlyAuthenticatedUsersCanCreateForm
{
    public function handle(BeforeRouteAction $event)
    {
        $event->routeName == RouteName::CREATE_FORM &&
        tenant_config("only_authenticated_users_can_create_forms") &&
        Authenticator::user() == null && $this->setMessage($event);
    }

    protected function setMessage($event)
    {
        $event->shouldPermit(false);
        $event->setPermissionDenied("Login is required");
    }
}