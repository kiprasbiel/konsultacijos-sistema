<?php


namespace App\CustomClasses;


use App\Client;
use App\Theme;
use App\User;

class ImportClass
{
    public function importArray($path){
        $perv_arr = [];
        foreach (file($path) as $key => $con){
            try {
                $con_arr = explode(';', $con);
                if (strpos($con_arr[1], '"') !== false){
                    if ($con_arr[1][0] == '"'){
                        $con_arr[1] = preg_replace('/^"/', '', $con_arr[1]);
                        $con_arr[1] = preg_replace('/""/', '"', $con_arr[1]);
                        $con_arr[1] = preg_replace('/""/', '"', $con_arr[1]);
                    }
                    $con_formatted_arr['client_id'] = Client::where('name', $con_arr[1])->value('id');
                }
                else{
                    $con_formatted_arr['client_id'] = Client::where('name', $con_arr[1])->value('id');
                }

                $con_formatted_arr['created_by'] = auth()->user()->id;
                $con_formatted_arr['contacts'] = $con_arr[2];

                $theme_column = explode(' (', $con_arr[3]);
                $con_formatted_arr['theme_id'] = Theme::where('name', $theme_column[0])->value('id');
                $consultant = trim(preg_replace('/[()]/', '', $theme_column[1]));
                $con_formatted_arr['user_id'] = User::where('name', $consultant)->value('id');

                $con_formatted_arr['address'] = $con_arr[4];

                $con_formatted_arr['consultation_date'] = str_replace('.', '-', $con_arr[5]);

                $con_time = strtolower($con_arr[6]);
                if (strpos($con_time, 'pertrauka')) {
                    $con_time_arr = explode('pertrauka', $con_time);

                    $con_formatted_arr['consultation_time'] = trim(preg_replace('/(\D)+/', ':', $con_time_arr[0]), ':');

                    $con_break_arr = explode('-', $con_time_arr[1]);
                    $con_formatted_arr['break_start'] = $con_break_arr[0];
                    $con_formatted_arr['break_end'] = $con_break_arr[1];
                } else {
                    $con_formatted_arr['consultation_time'] = trim(preg_replace('/(\D)+/', ':', $con_time), ':');
                    $con_formatted_arr['break_start'] = null;
                    $con_formatted_arr['break_end'] = null;
                }

                $con_formatted_arr['consultation_length'] = $con_arr[7];
                $con_formatted_arr['method'] = ucfirst($con_arr[8]);
                $con_formatted_arr['county'] = strtolower(preg_replace('/\s/', '', $con_arr[9]));
                $con_formatted_arr['is_sent'] = 1;
                $con_formatted_arr['is_paid'] = 0;
                array_push($perv_arr, $con_formatted_arr);
            }
            catch (\ErrorException $e){
                var_dump("ERROR - " . $key);
            }
        }
        return $perv_arr;
    }
}
