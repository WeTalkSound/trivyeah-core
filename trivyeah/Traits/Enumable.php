<?php

namespace TrivYeah\Traits;

/**
 * Traits for enums
 */
trait Enumable
{
    public static function enums()
    {
        return array_values(static::constants());
    }

    public static function constants()
    {
        $reflectionClass = new \ReflectionClass(static::class);
        return $reflectionClass->getConstants();
    }

    public function __toString()
    {
        return implode("," , static::enums());
    }

    public static function new()
    {
        return new static;
    }

    public static function enumsExcept()
    {
        $keys = func_get_args();
        $constants = static::constants();

        foreach ($keys as $key) {
            unset($constants[$key]);
        }

        return array_values($constants);
    }

    public static function random()
    {
        $constants = static::constants();
        return $constants[array_rand($constants)];
    }
}