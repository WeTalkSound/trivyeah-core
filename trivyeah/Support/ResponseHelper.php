<?php

namespace TrivYeah\Support;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;

class ResponseHelper
{
    /**
     * Send a unified failure message.
     * @param mixed $errors,
     * @param int $code
     * 
     * @throws HttpResponseException
     */
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