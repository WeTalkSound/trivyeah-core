<?php

namespace TrivYeah\Providers;

use TrivYeah\Validators\ExistsWith;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class CustomValidatorProvider extends ServiceProvider
{
    /**
     * Hold Custom Validators
     * @var array
     */
    protected $customValidators = [
        ExistsWith::class
    ];

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        foreach ($this->customValidators as $customValidator) {
            $customValidator = $this->app->make($customValidator);
            Validator::extend($customValidator->getName(), function (
                $attribute, 
                $value, 
                $parameters, 
                $validator) use ($customValidator) {
                $validator->setCustomMessages($customValidator->customMessages($attribute));
                return $customValidator->evaluate(...func_get_args());
            });
            Validator::replacer($customValidator->getName(), function() 
                use ($customValidator) {
                return $customValidator->replace(...func_get_args());
            });
        }
    }
}