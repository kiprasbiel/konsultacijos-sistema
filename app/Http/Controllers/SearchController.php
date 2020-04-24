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
                'contacts' => $client->contacts,
                'vkt' => $client->vkt,
                'expo' => $client->expo,
                'eco' => $client->eco,
            ];
        }
        return Response::json($formatted_clients);
    }

    public function searchid($id){
        $client = Client::find($id);
//        $formatted_clients = [];
        $formatted_clients = [
            'id' => $client->id,
            'text' => $client->name,
            'code' => $client->code,
            'company_reg_date' => $client->company_reg_date,
            'contacts' => $client->contacts,
            'vkt' => $client->vkt,
            'expo' => $client->expo,
            'eco' => $client->eco,
        ];
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
}
