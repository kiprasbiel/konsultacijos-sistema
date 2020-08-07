<?php

namespace App;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use DateTime;
use Exception;
use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    /**
     * @return \DateInterval|false
     * @throws Exception
     */
    public function break_len(){
        $break_raw = Consultation_meta::where('consultation_id', $this->id)->where('type', 'consultation_break')->pluck('value');
        $break_json = json_decode($break_raw[0]);
        $diff_date = new DateTime('00:00');
        $ref_date = clone $diff_date;
        foreach ($break_json as $single_break){
            $start_time = new DateTime($single_break->break_start);
            $end_time = new DateTime($single_break->break_end);
            $diff_date->add($start_time->diff($end_time));
        }
        return $ref_date->diff($diff_date);
    }

    /**
     * Returns actual consultation length
     * including breaks
     * @return string
     * @throws Exception
     */
    public function con_actual_len(){
        $con_len_time = new DateTime($this->consultation_length);
        return $con_len_time->add($this->break_len())->format('H:i');
    }

    /**
     * Returns consultation end datetime
     * including breaks
     * @return Carbon
     * @throws Exception
     */
    public function con_end_datetime(){
        if (substr_count($this->consultation_time, ':') == 1){
            $con_start_date = Carbon::createFromFormat('Y-m-d H:i', $this->consultation_date . ' ' . $this->consultation_time);
        }
        else{
            $con_start_date = Carbon::createFromFormat('Y-m-d H:i:s', $this->consultation_date . ' ' . $this->consultation_time);
        }
        $con_len_time = CarbonInterval::createFromFormat('H:i', $this->con_actual_len());
        return $con_start_date->add($con_len_time);
    }

    /**
     * Checks if consultation has already been
     * Returns:
     * true for passed
     * false for to be still
     * @return bool
     * @throws Exception
     */
    public function is_con_over(){
        $now = Carbon::now('Europe/Vilnius');
        if ($this->con_end_datetime()->greaterThan($now)){
            return false;
        }
        else{
            return true;
        }
    }

    /**
     * @return bool
     */
    public function has_breaks(){
        $break_raw = Consultation_meta::where('consultation_id', $this->id)->where('type', 'consultation_break')->get()->toArray();
        if (!empty($break_raw)){
            return json_decode($break_raw[0]['value']);
        }
        else{
            return false;
        }
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
