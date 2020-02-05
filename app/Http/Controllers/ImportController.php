<?php

namespace App\Http\Controllers;

use App\Client;
use App\Consultation;
use App\CustomClasses\ImportClass;
use App\Theme;
use App\User;
use ErrorException;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index(){
        return view('settings.import-index');
    }

    public function import(Request $request){
        $this->validate($request, [
            'csv' => 'required|File',
        ]);
        $path = $request->file('csv')->getRealPath();
        $import = new ImportClass;
        $perv_arr = $import->importArray($path);

        if ($request->action == 'Tikrinti'){
            return view('settings.import-index')->with('con_arr', $perv_arr)->with('file_path', $path);
        }

        foreach ($perv_arr as $con){
            $consultation = new Consultation;
            $consultation->client_id = $con['client_id'];
            $consultation->user_id = $con['user_id'];
            $consultation->contacts = $con['contacts'];
            $consultation->theme_id = $con['theme_id'];
            $consultation->county = $con['county'];
            $consultation->address = $con['address'];
            $consultation->consultation_date = $con['consultation_date'];
            $consultation->consultation_time = $con['consultation_time'];
            $consultation->consultation_length = $con['consultation_length'];
            $consultation->method = $con['method'];
            $consultation->is_paid = 0;
            $consultation->created_by = $con['created_by'];
            $consultation->break_start = $con['break_start'];
            $consultation->break_end = $con['break_end'];
            $consultation->is_sent = 1;
            $consultation->save();
        }
        return redirect('/konsultacijos')->with('success', count($perv_arr) . " konsultacijos sėkmingai įkeltos");

    }

    public function save($path){
        $import = new ImportClass;
        $perv_arr = $import->importArray($path);
        dd($perv_arr);
    }
}
