<?php

namespace App\Rules;

use Carbon\Carbon;
use Illuminate\Contracts\Validation\Rule;

class AfterTomorrow implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($old)
    {
        $this->is_old = $old;
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
        //Jei konsultacija sena - praleisti tikrinima
        if ($this->is_old == 'on') {
            return true;
        }

        $con_date = Carbon::createFromFormat('Y-m-d', $value);
        $con_date->startOfDay();
        $tomorrow = Carbon::tomorrow();

        if($con_date->greaterThan($tomorrow)){
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Naujos konsultacijos data turi būti diena po rytojaus';
    }
}
