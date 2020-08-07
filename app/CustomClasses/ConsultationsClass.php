<?php


namespace App\CustomClasses;


use Carbon\Carbon;
use Carbon\CarbonInterval;
use DateTime;

class ConsultationsClass
{
//    public function break_len_calc($start, $end){
//        $start_time = new DateTime($start);
//        $end_time = new DateTime($end);
//        return $start_time->diff($end_time);
//    }

//    public function actual_con_length($break_len, $con_len){
//        $con_len_time = new DateTime($con_len);
//        return $con_len_time->add($break_len)->format('H:i');
//    }

//    public function con_end_datetime($con_start_time, $con_start_date, $con_len){
//        if (substr_count($con_start_time, ':') == 1){
//            $con_start_date = Carbon::createFromFormat('Y-m-d H:i', $con_start_date . ' ' . $con_start_time);
//        }
//        else{
//            $con_start_date = Carbon::createFromFormat('Y-m-d H:i:s', $con_start_date . ' ' . $con_start_time);
//        }
//        $con_len_time = CarbonInterval::createFromFormat('H:i', $con_len);
//        return $con_start_date->add($con_len_time);
//    }

//    public function is_con_over($con_end){
//        $now = Carbon::now('Europe/Vilnius');
//        if ($con_end->greaterThan($now)){
//            return false;
//        }
//        else{
//            return true;
//        }
//    }
}
