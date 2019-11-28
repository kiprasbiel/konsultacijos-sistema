<?php

namespace App\Http\Controllers;

use App\Consultation;
use Illuminate\Http\Request;
use App\Client;
use Response;
use Illuminate\Support\Facades\DB;


class SearchController extends Controller
{
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
                'contacts' => $client->contacts
            ];
        }
        return Response::json($formatted_clients);
    }

    //Ajax temu filtravimas pagal imones registracijos data ir pagrindine tema
    public function themeSearch(Request $request){
        $main_theme = $request->theme;
        $how_old = $request->how_old;

        //Gaunam visas temas, kurios atitinka imones registracijos pagrindine tema
        $themes = DB::select('SELECT * FROM `themes` WHERE `main_theme` = "' . $main_theme .'" AND ((`min_old` < '. $how_old . ' AND `max_old`> '. $how_old . ') OR (ISNULL(`min_old`) AND `max_old`> '. $how_old . ') OR (`min_old` < '. $how_old . ' AND ISNULL(`max_old`)) OR (ISNULL(`min_old`) AND ISNULL(`max_old`)))');
        $formatted_themes = [];
        foreach ($themes as $theme) {
            $formatted_themes[] = [
                'id' => $theme->id,
                'name' => $theme->name,
                'theme_number' => $theme->theme_number,
                'min_old' => $theme->min_old,
                'max_old' => $theme->max_old
            ];
        }
        return $themes;

        //Issifiltruojam temas kurios atitinka imones registracijos data


    }

    //Konsultaciju paieska
    public function consultation_search(Request $request){
        $user_id = auth()->user()->id;
        $unsent = Consultation::where('user_id', $user_id)->where('is_sent', 0)->count();

        $consultations = Consultation::whereHas('client', function ($query) use ($request){
            $query->where('name', 'like', "%{$request->paieska}%");
        })->where('user_id', $user_id)->orderBy('id', 'desc')->paginate(50);

        return view('consultations.index')->with('consultations', $consultations)->with('unsent', $unsent);
    }

    //Klientu paieska
    public function client_search(Request $request){
        $clients =  Client::orderBy('created_at', 'desc')->where('name', 'like', "%{$request->paieska}%")->paginate(50);
        return view('clients.index')->with('clients', $clients);
    }

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
}
