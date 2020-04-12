<?php

namespace Tenant\ResourceValidators;

class PlainTextValidator extends ResourceValidator
{
    public function validate(): self
    {
        return $this;

    }
}