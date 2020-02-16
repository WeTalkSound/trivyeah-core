<?php

namespace TrivYeah\Support;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResponseHelper
{
    public static function fail($errors, $code = Response::HTTP_UNPROCESSABLE_ENTITY) 
    {
        $errors = is_array($errors) ? $errors : [$errors];

        $jsonResponse = response()->json(
            ['data' => ['errors' => $errors]], 
            $code
        );

        throw new HttpResponseException($jsonResponse);
    }
}