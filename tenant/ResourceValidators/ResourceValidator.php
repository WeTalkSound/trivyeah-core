<?php

namespace Tenant\ResourceValidators;

use TrivYeah\Support\Fluent;
use TrivYeah\Support\ResponseHelper;

abstract class ResourceValidator
{
    /**
     * Data Transfer Object
     * @var TrivYeah\Support\Fluent
     */
    protected $dto;

    /**
     * Errors
     * @var \Illuminate\Support\Collection
     */
    protected $errors;

    public function __construct(Fluent $dto)
    {
        $this->dto = $dto;
        $this->errors = collect();
    }

    public static function make(Fluent $dto)
    {
        return new static($dto);
    }

    abstract public function validate();

    public function hasErrors()
    {
        return $this->errors->isNotEmpty();
    }

    public function errors()
    {
        return $this->errors->all();
    }

    public function fail()
    {
        return $this->hasErrors() == false ?: 
                ResponseHelper::fail(
                    $this->errors()
            );
    }

    public function validateAndFail()
    {
        return $this->validate()->fail();
    }
}