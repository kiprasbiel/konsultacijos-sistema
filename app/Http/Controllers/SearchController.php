<?php

namespace App\Http\Controllers;

use App\Consultation;
use Illuminate\Http\Request;
use App\Client;
use Response;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }

    //Ajax gauti imones slect laukeliui konsultacijos pasirinkime
    public function search(Request $request){

        $term = trim($request->q);
        if (empty($term)) {
            return Response::json([]);
        }
        $clients = Client::where('name', 'like', '%'.$term.'%')->get();
        $formatted_clients = [];
        foreach ($clients as $client) {
            $formatted_clients[] = [
                'id' => $client->id,
                'text' => $client->name,
                'code' => $client->code,
                'company_reg_date' => $client->company_reg_date,
                'con_type' => $client->con_type,
                'contacts' => $client->contacts,
                'vkt' => $client->vkt,
                'expo' => $client->expo,
                'eco' => $client->eco,
            ];
        }
        return Response::json($formatted_clients);
    }

    //Ajax temu filtravimas pagal imones registracijos data ir pagrindine tema
    public function themeSearch(Request $request){
        $full_array = [];

        if (!is_null($request->vkt)){
//            $themes_vkt = DB::select('SELECT * FROM `themes` WHERE `type` = "' . $request->vkt .'"');
            $themes_vkt = DB::select('SELECT * FROM `themes` WHERE `main_theme` = "VKT"');
            $tarpinis_vkt = [];
            foreach ($themes_vkt as $theme_vkt){
                $vidus = [
                    'theme_number' => $theme_vkt->theme_number,
                    'id' => $theme_vkt->id,
                    'text' => $theme_vkt->name,
                    'theme' => 'VKT'
                ];
                $full_array[] = $vidus;
            }
        }

        if (!is_null($request->expo)){
//            $themes_expo = DB::select('SELECT * FROM `themes` WHERE `type` = "' . $request->expo .'"');
            $themes_expo = DB::select('SELECT * FROM `themes` WHERE `main_theme` = "EXPO"');
            $tarpinis_expo = [];
            foreach ($themes_expo as $theme_expo){
                $vidus = [
                    'theme_number' => $theme_expo->theme_number,
                    'id' => $theme_expo->id,
                    'text' => $theme_expo->name,
                    'theme' => 'EXPO'
                ];
                $full_array[] = $vidus;
            }
        }

        if (!is_null($request->eco)){
            $themes_eco = DB::select('SELECT * FROM `themes` WHERE `main_theme` = "ECO"');
            $tarpinis_eco = [];
            foreach ($themes_eco as $theme_eco){
                $vidus = [
                    'theme_number' => $theme_eco->theme_number,
                    'id' => $theme_eco->id,
                    'text' => $theme_eco->name,
                    'theme' => 'ECO'
                ];
                $full_array[] = $vidus;
            }
        }
        return $full_array;

    }

    //Konsultaciju paieska
//    public function consultation_search(Request $request){
//        $user_id = auth()->user()->id;
//        $unsent = Consultation::where('user_id', $user_id)->where('is_sent', 0)->count();
//
//        $consultations = Consultation::whereHas('client', function ($query) use ($request){
//            $query->where('name', 'like', "%{$request->paieska}%");
//        })->where('user_id', $user_id)->orderBy('id', 'desc')->paginate(50);
//
//        return view('consultations.index')->with('consultations', $consultations)->with('unsent', $unsent);
//    }
//
//    //Klientu paieska
//    public function client_search(Request $request){
//        $clients =  Client::orderBy('created_at', 'desc')->where('name', 'like', "%{$request->paieska}%")->paginate(50);
//        return view('clients.index')->with('clients', $clients);
//    }

    public function themeListSearch(Request $request){
        $id = $request->company_id;
        $clients = Client::select('company_reg_date', 'con_type')->where('id', $id)->get();
        foreach ($clients as $client){
            $main_theme = $client->con_type;

            $ivestaData = date_create($client->company_reg_date);
            $esamaData = date("Y-m-d");
//            $how_old = ($esamaData - $ivestaData) / 1000 / 60 / 60 / 24 / 365;
            $how_old = date_diff($ivestaData, $esamaData);
            return date_format($how_old, 'Y');
            $themes = DB::select('SELECT * FROM `themes` WHERE `main_theme` = "' . $main_theme .'" AND ((`min_old` < '. $how_old . ' AND `max_old`> '. $how_old . ') OR (ISNULL(`min_old`) AND `max_old`> '. $how_old . ') OR (`min_old` < '. $how_old . ' AND ISNULL(`max_old`)) OR (ISNULL(`min_old`) AND ISNULL(`max_old`)))');
        }
        return $themes;
    }

//    public function tableSearchColumn(Request $request){
//        dd($request->input());
//        $className = 'App\\'.$request->model;
//
//        if (strpos($request->column, '.') !== false){
//            $column_explode = explode('.', $request->column);
//            $model_realtion = $column_explode[0];
//            $model_realtion_column = $column_explode[1];
//
//            $model_list = $className::whereHas($model_realtion, function ($query) use ($request, $model_realtion_column){
//                $query->where($model_realtion_column, 'like', "%{$request->paieska}%");
//            })->orderBy('id', 'desc')->paginate(50);
//        }
//        else{
//            $model_list = $className::where($request->column, $request->paieska)->orderBy('id', 'desc')->paginate(50);
//        }
//
//        return view('consultations.index')->with('consultations', $model_list)->with('unsent', $unsent);
//
//    }
}
