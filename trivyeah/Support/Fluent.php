<?php

namespace TrivYeah\Support;

use Illuminate\Support\Fluent as Base;

class Fluent extends Base
{
    public function getOrCollect($attribute)
    {
        return $this->get($attribute, collect());
    }

    public function getOrFluent($attribute)
    {
        return $this->get($attribute, fluent());
    }

    public function has($attribute)
    {
        return (bool) $this->get($attribute);
    }
}