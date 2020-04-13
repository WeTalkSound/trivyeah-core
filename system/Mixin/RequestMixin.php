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
            $load = array_merge(
                $this->all(), 
                $this->route()->parameters()
            );
            return array_shape($load, $this->mapToDb);
        };
    }

    /**
     * Get Data Transfer Object From Validated Request
     * @return Closure
     */
    public function dtoFromValidated()
    {
        return function () {
            $load = array_merge(
                $this->validated(), 
                $this->route()->parameters()
            );
            return array_shape($load, $this->mapToDb);
        };
    }
}