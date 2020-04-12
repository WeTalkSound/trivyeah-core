<?php

namespace System\Mixin;

class RequestMixin
{

    /**
     * Get Data Transfer Object From Request Body
     * @return Closure
     */
    public function dto()
    {
        return function () {
            return array_shape($this->all(), $this->mapToDb);
        };
    }

    /**
     * Get Data Transfer Object From Validated Request
     * @return Closure
     */
    public function dtoFromValidated()
    {
        return function () {
            return array_shape($this->validated(), $this->mapToDb);
        };
    }
}