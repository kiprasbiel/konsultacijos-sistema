<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ValidateCompanyCode implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if(strlen($value) == 7 || strlen($value) == 9 || strlen($value) == 11){
            return true;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Įmonės kodą turi sudaryti 7 arba 9 skaitmenys.';
    }
}
