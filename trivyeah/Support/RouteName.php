<?php

namespace TrivYeah\Support;

use TrivYeah\Traits\Enumable;

class RouteName
{
    use Enumable;
    
    const CREATE_FORM = "create-form";
    const LIST_FORMS = "list-forms";
    const VIEW_FORM = "view-form";
    const DELETE_FORM = "delete-form";
    const UPDATE_FORM = "update-form";
    const IMPORT_FORM = "import-form";
    const BEGIN_RESPONSE = "begin-response";
    const END_RESPONSE = "end-response";
}