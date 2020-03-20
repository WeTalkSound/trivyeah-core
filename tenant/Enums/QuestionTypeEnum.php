<?php

namespace Tenant\Enums;

use TrivYeah\Traits\Enumable;

class QuestionTypeEnum
{
    use Enumable;

    const PLAIN_TEXT = "plain text";
    const MULTIPLE_CHOICE = "multiple choice";
}