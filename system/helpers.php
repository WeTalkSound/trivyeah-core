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

if (! function_exists("array_shape")) {
    /**
     * Transform an array to a fluent or collection class
     * @param array $attributes
     * 
     * @return \TrivYeah\Support\Fluent
     */
    function array_shape($convertables = null, $accessor = []) {
        if (is_array($convertables)) {

            foreach($convertables as $key => $value) {
                $dto[$accessor[$key] ?? $key] = array_shape($value);
            }
            $dto = $dto ?? [];
            return is_array_assoc($dto) ? fluent($dto) : collect($dto);
        }
        return $convertables;
    }
}

if (! function_exists("array_unshape")) {
    /**
     * Transform a fluent or collection class to an array
     * @param array $attributes
     * 
     * @return \TrivYeah\Support\Fluent
     */
    function array_unshape($convertables = null) {
        if  (!$convertables instanceOf ArrayAccess && !is_array($convertables)) {
           return $convertables;
        }
        
        if ($convertables instanceOf ArrayAccess) {
            $convertables = $convertables->toArray();
        }

        foreach ($convertables as $key => $value) {
            $dto[$key] = array_unshape($value);
        }
        return $dto ?? [];
    }
}