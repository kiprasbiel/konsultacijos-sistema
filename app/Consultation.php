<?php

namespace App;

use App\CustomClasses\ConsultationsClass;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{

    /**
     * Return Consultations break length in minutes
     * @return \DateInterval|false
     */
    public function break_len(){
        $con_class = new ConsultationsClass();
        return $con_class->break_len_calc($this->break_start, $this->break_end);
    }

    /**
     * Returns actual consultation length
     * including breaks
     * @return string
     */
    public function con_actual_len(){
        $con_class = new ConsultationsClass();
        return $con_class->actual_con_length($this->break_len(), $this->consultation_length);
    }

    /**
     * Returns consultation end time
     * including breaks
     * @return \Carbon\Carbon
     */
    public function con_end_datetime(){
        $con_class = new ConsultationsClass();
        return $con_class->con_end_datetime($this->consultation_time, $this->consultation_date, $this->con_actual_len());
    }

    /**
     * Checks if consultation has already been
     * Returns:
     * true for passed
     * false for to be still
     * @return bool
     */
    public function is_con_over(){
        $con_class = new ConsultationsClass();
        return $con_class->is_con_over($this->con_end_datetime());
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }
    public function theme(){
        return $this->belongsTo(Theme::class);
    }
    public function user(){
        return $this->belongsTo(User::class);
    }
    public function consultation_meta(){
        return $this->hasMany(Consultation_meta::class);
    }
}
