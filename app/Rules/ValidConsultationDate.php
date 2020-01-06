<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Carbon\Carbon;

class ValidConsultationDate implements Rule
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

        $now = Carbon::now();
        $carbon_value = Carbon::createFromFormat('Y-m-d', $value);
        $diff = $now->diffInDays($carbon_value);

        //Tikrinam ar yra bent viena darbo diena tarp dabar ir konsultacijos datos
        for ($i = 1; $i <= $diff; $i++) {
            $carbon_value->subDay();
            if ($carbon_value->isWeekDay() && $carbon_value->notEqualTo($now)){
                return true;
            }
            else{
                continue;
            }
        }

        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Iki konsultacijos datos turi likti daugiau nei 1 darbo diena.';
    }
}
