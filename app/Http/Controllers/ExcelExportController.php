<?php

namespace App\Http\Controllers;

use App\Exports\ConsultationExport;
use App\Exports\ConsultationMonthExport;
use App\Mail\ConsultationMonth;
use App\Theme;
use Illuminate\Http\Request;
//use Maatwebsite\Excel\Excel;
Use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConsultationMail;
use App\Consultation;
use App\User;
use App\Client;



class ExcelExportController extends Controller
{
    public function store(){
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $selection = $user->consultations->where('is_sent', 0);
        $total = $selection->count();
        $all_data = $selection->toArray();
        $new_array = [];
        //Pridedamas numeravimas
        $index = 1;
        foreach ($all_data as $data){
            unset(
                $data['id'],
                $data['created_at'],
                $data['updated_at'],
                $data['is_sent'],
            );

            $county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];

//            $consultation_date_split = explode(" ", $data['consultation_date']);
            $consultation_start = explode(":", $data['consultation_time']);

            $new_data = [
                'company_id' => Client::find($data['client_id'])->name,
                'contacts' => $data['contacts'],
                'theme' => Theme::find($data['theme_id'])->name . "\n(" . User::find($data['user_id'])->name . ")",
                'address' => $data['address']. "\n" . $county_list[$data['county']],
                'consultation_date' => str_replace("-", ".", $data['consultation_date']),
                'consultation_start' => $consultation_start[0] . " val. " . $consultation_start[1] . " min.",
                'consultation_length' => $data['consultation_length'],
                'method' => $data['method'],
            ];

            $array_values = array_values($new_data);
            array_unshift($array_values, $index);
            $new_array[] =  $array_values;
            $index++;
        }
        if ($total == 0){
            return redirect('/konsultacijos')->with('notice', '<strong>' . $total . '</strong> konsultacijų išsiųsta. Visos konsultacijos jau išsiųstos.');
        }

        //Nera jokiu pokyciu
        $changes = [];

        Mail::to('test@test.com')->send(new ConsultationMail($new_array, $changes));

        Consultation::where('is_sent', 0)->where('user_id', $user_id)->update(['is_sent' => 1]);

        return Excel::download(new ConsultationExport($new_array, $changes),'konsultacijos.xlsx');
        return redirect('/konsultacijos')->with('success', 'Sėkmingai sugeneruotos ir išsiųstos <strong>' . $total . '</strong> konsultacijos');
    }

    public function month(){
        $currant_date = date("Y-m");
        $consultations = Consultation::where('paid_date', 'like', $currant_date.'%')->where('is_paid', 1)->get();
        if (count($consultations) == 0){
            return redirect('/')->with('error', 'Nei viena šio mėnesio konsultacija nėra apmokėta!');
        }
        $consultations_array = $consultations->toArray();
        $all_data = [];
        foreach ($consultations_array as $consultation){
            $client = Client::find($consultation['client_id']);
            $imones_reg_apskrt = strtoupper(str_replace("-", "_", $client->reg_county));
            $konsultacijos_apskrt = strtoupper(str_replace("-", "_", $consultation['county']));
            $kons_trukme = explode(':',$consultation['consultation_length']);
            $kon_pradzia = explode(':', $consultation['consultation_time']);

            //Tikrinam ar laikas !=0
            if ((int)$kons_trukme[0]==0){
                $kons_trukme[0] = "0";
            }
            else{
                $kons_trukme[0] = (int)$kons_trukme[0];
            }

            if ((int)$kons_trukme[1]==0){
                $kons_trukme[1] = "0";
            }
            else{
                $kons_trukme[1] = (int)$kons_trukme[1];
            }

            if ((int)$kon_pradzia[0]==0){
                $kon_pradzia[0] = "0";
            }
            else{
                $kon_pradzia[0] = (int)$kon_pradzia[0];
            }

            if ((int)$kon_pradzia[1]==0){
                $kon_pradzia[1] = "0";
            }
            else{
                $kon_pradzia[1] = (int)$kon_pradzia[1];
            }

            //Info formavimas excel'iui
            $data = [
                'konsultanto_pavadinimas' => "Asociacija \"Visuomenės\npažangos institutas\"",
                'konsultanto_kodas' => '302537169',
                'paslaugos_gavejas' => $client->name,
                'imones_kodas' => $client->code,
                'imones_reg_data' => $client->company_reg_date,
                'imones_reg_apskrt' => $imones_reg_apskrt,
                'konsultacijos_tipas' => 'NEAISKU',
                'temos_kodas' => Theme::find($consultation['theme_id'])->theme_number,
                'konsultacijos_data' => str_replace("-", ".", $consultation['consultation_date']),
                'dalyvavo' => 'Taip',
                'pasirase_sf' => 'Taip',
                'kons_saviv' => $konsultacijos_apskrt,
                'kon_trukme_h' =>$kons_trukme[0],
                'kon_trukme_min' =>$kons_trukme[1],
                'kon_prad_h' => $kon_pradzia[0],
                'kon_prad_min' => $kon_pradzia[1],
                'apmokejimo_data' => $consultation['paid_date'],
                'ar_apmoketa' => 'Taip',
                'pastaba' => ucfirst($consultation['method']),
                'vl_veiksmai' => ' '
            ];
            $all_data[] = $data;
        }

        Mail::to('test@test.com')->send(new ConsultationMonth($all_data));

        return Excel::download(new ConsultationMonthExport($all_data),'menesio-ataskaita.xlsx');
        return redirect('/')->with('success', 'Sėkmingai sugeneruotos ir išsiųstos mėnesio konsultacijos');
    }
}
