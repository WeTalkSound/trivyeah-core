<?php

namespace TrivYeah\Validators;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Schema;

/**
 * 
 * Validates that the given value exists with other column values
 */

class ExistsWith
{
    /**
     * Request
     * @var Request
     */
    protected $request;

     /**
     * Name of the validator.
     * 
     * @var string 
     */
    protected $name = "exists_with";

    /**
     * @param Illuminate\Http\Request
     * 
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Return the name of the validator.
     * 
     * @return string name of the validator
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * 
     * @param string $message
     * @param string $attribute
     * @param string $rule
     * @param array $parameters
     */
    public function replace(string $message, string $attribute, string $rule, array $parameters){
        return $message;
    }

    /**
     * 
     * @param string $attribute
     * @param mixed $value
     * @param array $parameters
     * @param Validator $validator
     * @return bool
     * @throws \Exception
     */
    public function evaluate(string $attribute, $value, array $parameters, Validator $validator){
        $parameters = collect($parameters);
        $table = $parameters->first();
        $softDeleteField = "deleted_at";

        $attribute  = $parameters->get(1, $attribute);
        $otherAttributes = $parameters->slice(2);
        $usesSoftDelete = Schema::hasColumn($table, $softDeleteField);
        
        $query =  DB::table($table)->where($attribute, $value);

        $otherAttributes->mapInTwos(function ($column, $val) use ($query) {
            $query->where($column, $this->guessValue($val));
        });

        return $usesSoftDelete 
                    ? $query->whereNull($softDeleteField)->exists()
                    : $query->exists();
    }

    /**
     * Guess the value of the column
     */
    protected function guessValue($value)
    {
        return $this->request->$value ?? $value;
    }

    /**
     * Custom error messages
     * 
     * @return array
     */
    public function customMessages($attribute)
    {
        return [
            $this->name => "Can't retrive {$attribute} details"
        ];
    }
}