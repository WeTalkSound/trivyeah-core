<?php

use Illuminate\Support\Fluent;
use Illuminate\Support\Collection;

if (! function_exists("is_array_assoc")) {
    /**
     * Checks if the given array is an associative array
     * @param array $array
     * 
     * @return bool
     */
    function is_array_assoc(array $array) {
        if ([] === $array) return false;
        return array_keys($array) !== range(0, count($array) - 1);
    }
}

if (! function_exists("fluent")) {
    /**
     * Return a new \TrivYeah\Support\Fluent class
     * @param array $attributes
     * 
     * @return \TrivYeah\Support\Fluent
     */
    function fluent($attributes = []) {
        return new \TrivYeah\Support\Fluent($attributes);
    }
}

if (! function_exists("reshape")) {
    /**
     * Transform an array to a fluent or collection class
     * @param array $attributes
     * 
     * @return \TrivYeah\Support\Fluent
     */
    function reshape($convertables = null, $accessor = []) {
        if (is_array($convertables)) {

            foreach($convertables as $key => $value) {
                $dto[$accessor[$key] ?? $key] = reshape($value);
            }
            $dto = $dto ?? [];
            return is_array_assoc($dto) ? fluent($dto) : collect($dto);
        }
        return $convertables;
    }
}

if (! function_exists("unshape")) {
    /**
     * Transform a fluent or collection class to an array
     * @param array $attributes
     * 
     * @return \TrivYeah\Support\Fluent
     */
    function unshape($convertables = null, $accessor = []) {
        if  ($convertables instanceOf ArrayAccess) {

            foreach ($convertables->toArray() as $key => $value) {
                $dto[$key] = unshape($value);
            }
            return $dto ?? [];
        }
        return $convertables;
    }
}