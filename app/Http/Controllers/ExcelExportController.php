<?php

namespace App\Http\Controllers;

use App\Exports\ConsultationExport;
use App\Exports\ConsultationMonthExport;
use App\Mail\ConsultationMonth;
use App\Option;
use App\Theme;
use Illuminate\Http\Request;
Use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConsultationMail;
use App\Consultation;
use App\User;
use App\Client;


class ExcelExportController extends Controller
{
    public function __construct() {
        $this->middleware('auth');

    }

    public function store(Request $request) {

        if (is_null($request->input('send'))) {
            return redirect('/review')->with('notice', '<strong>' . 0 . '</strong> konsultacijų išsiųsta. Pažymėkite konsultacijas, kurias norite išsiųsti.');
        }

        $user_id = auth()->user()->id;
        $selection = Consultation::wherein('id', $request->input('send'))->get();
        $total = $selection->count();
        $all_data = $selection->toArray();

        $new_array = [];
        //Pridedamas numeravimas
        $index = 1;

        $county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];

        foreach ($all_data as $data) {
            unset(
                $data['id'],
                $data['created_at'],
                $data['updated_at'],
                $data['is_sent'],
            );

            $consultation_start = explode(":", $data['consultation_time']);

            if (!is_null($data['break_start']) && !is_null($data['break_end'])) {
                $consultation_start_str = $consultation_start[0] . " val. " . $consultation_start[1] . " min." . "\nPertrauka " . date("H:i", strtotime($data['break_start'])) . "-" . date("H:i", strtotime($data['break_end']));
            } else {
                $consultation_start_str = $consultation_start[0] . " val. " . $consultation_start[1] . " min.";
            }


            $new_data = [
                'company_id' => Client::find($data['client_id'])->name,
                'contacts' => $data['contacts'],
                'theme' => Theme::find($data['theme_id'])->name . "\n(" . User::find($data['user_id'])->name . ")",
                'address' => $data['address'] . "\n" . $county_list[$data['county']],
                'consultation_date' => str_replace("-", ".", $data['consultation_date']),
                'consultation_start' => $consultation_start_str,
                'consultation_length' => $data['consultation_length'],
                'method' => $data['method'],
            ];

            $array_values = array_values($new_data);
            array_unshift($array_values, $index);
            $new_array[] = $array_values;
            $index++;
        }

        //Nera jokiu pokyciu
        $changes = [];

        if ($request->input('action') == 'export') {
            return Excel::download(new ConsultationExport($new_array, $changes), 'konsultacijos.xlsx');
        } elseif ($request->input('action') == 'send') {
            $emails_arr = preg_split('/\n|\r\n?/', Option::where('name', 'emails')->value('value'));
            Mail::to($emails_arr)->send(new ConsultationMail($new_array, $changes));
            Consultation::wherein('id', $request->input('send'))->update(['is_sent' => 1]);
            return redirect('/konsultacijos')->with('success', 'Sėkmingai sugeneruotos ir išsiųstos <strong>' . $total . '</strong> konsultacijos');
        }
    }

    public function month($ex_date, $con_type, $action) {
        $con_type_lower = strtolower($con_type);
        $month = date_format(date_create($ex_date), 'm');
        $year = date_format(date_create($ex_date), 'Y');
        $currant_date = $ex_date;
        $consultations = Consultation::where('paid_date', 'like', $currant_date . '%')
            ->where('is_paid', 1)
            ->whereHas('client', function ($query) use ($con_type) {
                $query->whereNotNull($con_type);
            })
            ->get();
        if (count($consultations) == 0) {
            return redirect('/conf-month-gen')->with('error', 'Nei viena šio mėnesio konsultacija nėra apmokėta!');
        }
        $consultations_array = $consultations->toArray();
        $all_data = [];
        foreach ($consultations_array as $consultation) {

            $client = Client::find($consultation['client_id']);
            $imones_reg_apskrt = strtoupper(str_replace("-", "_", $client->reg_county));
            $konsultacijos_apskrt = strtoupper(str_replace("-", "_", $consultation['county']));
            $kons_trukme = explode(':', $consultation['consultation_length']);
            $kon_pradzia = explode(':', $consultation['consultation_time']);

            //Tikrinam ar laikas !=0
            if ((int)$kons_trukme[0] == 0) {
                $kons_trukme[0] = "0";
            } else {
                $kons_trukme[0] = (int)$kons_trukme[0];
            }

            if ((int)$kons_trukme[1] == 0) {
                $kons_trukme[1] = "0";
            } else {
                $kons_trukme[1] = (int)$kons_trukme[1];
            }

            if ((int)$kon_pradzia[0] == 0) {
                $kon_pradzia[0] = "0";
            } else {
                $kon_pradzia[0] = (int)$kon_pradzia[0];
            }

            if ((int)$kon_pradzia[1] == 0) {
                $kon_pradzia[1] = "0";
            } else {
                $kon_pradzia[1] = (int)$kon_pradzia[1];
            }

            if ($con_type == 'ECO') {
                $data = [
                    'konsultanto_pavadinimas' => "Viešoji įstsaiga\n Promas",
                    'konsultanto_kodas' => '304690879',
                    'paslaugos_gavejas' => $client->name,
                    'imones_kodas' => $client->code,
                    'imones_reg_data' => $client->company_reg_date,
                    'imones_reg_apskrt' => $imones_reg_apskrt,
                    'temos_kodas' => Theme::find($consultation['theme_id'])->theme_number,
                    'konsultacijos_data' => str_replace("-", ".", $consultation['consultation_date']),
                    'dalyvavo' => 'Taip',
                    'pasirase_sf' => 'Taip',
                    'kons_saviv' => $konsultacijos_apskrt,
                    'kon_trukme_h' => $kons_trukme[0],
                    'kon_trukme_min' => $kons_trukme[1],
                    'kon_prad_h' => $kon_pradzia[0],
                    'kon_prad_min' => $kon_pradzia[1],
                    'apmokejimo_data' => $consultation['paid_date'],
                    'ar_apmoketa' => 'Taip',
                    'pastaba' => ucfirst($consultation['method']),
                    'vl_veiksmai' => ' '
                ];
            } else {
                $data = [
                    'konsultanto_pavadinimas' => "Viešoji įstsaiga\n Promas",
                    'konsultanto_kodas' => '304690879',
                    'paslaugos_gavejas' => $client->name,
                    'imones_kodas' => $client->code,
                    'imones_reg_data' => $client->company_reg_date,
                    'imones_reg_apskrt' => $imones_reg_apskrt,
                    'konsultacijos_tipas' => $client->$con_type_lower,
                    'temos_kodas' => Theme::find($consultation['theme_id'])->theme_number,
                    'konsultacijos_data' => str_replace("-", ".", $consultation['consultation_date']),
                    'dalyvavo' => 'Taip',
                    'pasirase_sf' => 'Taip',
                    'kons_saviv' => $konsultacijos_apskrt,
                    'kon_trukme_h' => $kons_trukme[0],
                    'kon_trukme_min' => $kons_trukme[1],
                    'kon_prad_h' => $kon_pradzia[0],
                    'kon_prad_min' => $kon_pradzia[1],
                    'apmokejimo_data' => $consultation['paid_date'],
                    'ar_apmoketa' => 'Taip',
                    'pastaba' => ucfirst($consultation['method']),
                    'vl_veiksmai' => ' '
                ];
            }

            //Info formavimas excel'iui

            $all_data[] = $data;
        }

        if ($action == 'download') {
            return Excel::download(new ConsultationMonthExport($all_data, $con_type, $month, $year), 'menesio-ataskaita.xlsx');
        } else {
            $emails_arr = preg_split('/\n|\r\n?/', Option::where('name', 'emails')->value('value'));
            Mail::to($emails_arr)->send(new ConsultationMonth($all_data, $con_type, $month, $year));
            return redirect('/conf-month-gen')->with('success', 'Sėkmingai sugeneruotos ir išsiųstos mėnesio konsultacijos');
        }
    }

    public function index() {
        return view('exports.index');
    }

    public function configure(Request $request) {
        $this->validate($request, [
            'ex-date' => 'required',
            'con_type' => 'required',
        ]);
        return $this->month($request->input('ex-date'), $request->input('con_type'), $request->input('action'));
    }

}
