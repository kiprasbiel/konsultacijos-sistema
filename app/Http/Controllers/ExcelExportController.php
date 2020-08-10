<?php

namespace App\Http\Controllers;

use App\Consultation_meta;
use App\CustomClasses\ThemeClass;
use App\Exports\ConsultationExport;
use App\Exports\ConsultationMonthExport;
use App\Mail\ConsultationMonth;
use App\Option;
use App\Theme;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
Use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Mail\ConsultationMail;
use App\Consultation;
use App\User;
use App\Client;
use PhpOffice\PhpSpreadsheet\Shared\Date;


class ExcelExportController extends Controller
{
    public function __construct() {
        $this->middleware('auth');

    }

    public function store(Request $request) {

        if (is_null($request->input('send'))) {
            return redirect('/review')->with('notice', '<strong>' . 0 . '</strong> konsultacijų išsiųsta. Pažymėkite konsultacijas, kurias norite išsiųsti.');
        }

        $themes = ['VKT', 'EXPO', 'ECO'];
        $big_arr = [];
        $total = 0;
        foreach ($themes as $theme) {
            $selection = Consultation::wherein('id', $request->input('send'))
                ->whereHas('theme', function ($query) use ($theme) {
                    $query->where('main_theme', $theme);
                })
                ->orderBy('consultation_date', 'asc')
                ->orderBy('consultation_time', 'asc')
                ->get();
            if ($selection->count() > 0) {
                $total += $selection->count();
                $big_arr[$theme] = $selection->toArray();
            }
        }

        $all_con_arr = [];
        //Pridedamas numeravimas


        $county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];
        foreach ($big_arr as $key => $all_data) {
            $index = 1;
            $single_theme_cons_arr = [];
            foreach ($all_data as $data) {
                $meta_value = Consultation_meta::where('consultation_id', $data['id'])->where('type', 'consultation_break')->pluck('value')->first();
                unset(
                    $data['id'],
                    $data['created_at'],
                    $data['updated_at'],
                    $data['is_sent'],
                );

                $consultation_start = explode(":", $data['consultation_time']);

                $consultation_start_str = $consultation_start[0] . " val. " . $consultation_start[1] . " min.";
                if (!is_null($meta_value)) {
                    $decoded_json = json_decode($meta_value);
                    foreach($decoded_json as $single_break){
                        $consultation_start_str = $consultation_start_str . "\nPertrauka " . date("H:i", strtotime($single_break->break_start)) . "-" . date("H:i", strtotime($single_break->break_end));
                    }
                }

                // Laiko apskaiciavimas
                try {
                    $timestamp = new DateTime($data['consultation_length']);
                } catch (\Exception $e) {
                    dd($e);
                }
                $excelTimestamp = Date::PHPToExcel($timestamp);
                $excelDate = floor($excelTimestamp);
                $time = $excelTimestamp - $excelDate;

                $new_data = [
                    'company_id' => Client::find($data['client_id'])->name,
                    'contacts' => $data['contacts'],
                    'theme' => Theme::find($data['theme_id'])->name . "\n(" . User::find($data['user_id'])->name . ")",
                    'address' => $data['address'] . "\n" . $county_list[$data['county']],
                    'consultation_date' => str_replace("-", ".", $data['consultation_date']),
                    'consultation_start' => $consultation_start_str,
                    'consultation_length' => $time,
                    'method' => $data['method'],
                ];

                $array_values = array_values($new_data);
                array_unshift($array_values, $index);
                $single_theme_cons_arr[] = $array_values;
                $index++;
            }
            $all_con_arr[$key] = $single_theme_cons_arr;
        }

        //Nera jokiu pokyciu
        $changes = [];

        if ($request->input('action') == 'export') {
            $excel_header = Option::where('name', 'new_excel_header')->value('value');
            return Excel::download(new ConsultationExport($all_con_arr, $changes, $excel_header), 'konsultacijos.xlsx');
        } elseif ($request->input('action') == 'send') {
            $emails_arr = preg_split('/\n|\r\n?/', Option::where('name', 'emails')->value('value'));
            Mail::to($emails_arr)->send(new ConsultationMail($all_con_arr, $changes));
            Consultation::wherein('id', $request->input('send'))->update(['is_sent' => 1]);
            Consultation::wherein('id', $request->input('send'))->update(['email_sent_at' => Carbon::now()]);
            return redirect('/konsultacijos')->with('success', 'Sėkmingai sugeneruotos ir išsiųstos <strong>' . $total . '</strong> konsultacijos');
        }
    }

    public function month($ex_date, $con_type, $action, $payment, $is_sent, $con_date_type) {
        $themes_ids = Theme::get_theme_ids_by_main_theme($con_type);
        $con_type_lower = strtolower($con_type);
        $month = date_format(date_create($ex_date), 'm');
        $year = date_format(date_create($ex_date), 'Y');

        if ($is_sent == 'all'){
            $consultations = Consultation::where($con_date_type, 'like', $ex_date . '%')
                ->where('is_paid', $payment)
                ->whereIn('theme_id', $themes_ids)
                ->whereDoesntHave('consultation_meta', function ($query){
                    $query->where('type', 'draft_changes');
                })
                ->orderBy('client_id', 'desc')
                ->orderBy('consultation_date')
                ->get();
        }
        else{
            $consultations = Consultation::where($con_date_type, 'like', $ex_date . '%')
                ->where('is_paid', $payment)
                ->where('is_sent', $is_sent)
                ->whereIn('theme_id', $themes_ids)
                ->whereDoesntHave('consultation_meta', function ($query){
                    $query->where('type', 'draft_changes');
                })
                ->orderBy('client_id', 'desc')
                ->orderBy('consultation_date')
                ->get();
        }

        if (count($consultations) == 0) {
            return redirect('/conf-month-gen')->with('error', 'Nei viena šio mėnesio konsultacija neatitinka paieškos kriterijų!');
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
                    'konsultanto_pavadinimas' => "VšĮ \"Promas LT\"",
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
                    'konsultanto_pavadinimas' => "VšĮ \"Promas LT\"",
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
            //Abort if payment = 2
            if ($payment == 2){
                return redirect('/conf-month-gen')->with('error', 'Negalima siųsti neapmokėtų konsultacijų!');
            }
            $emails_arr = preg_split('/\n|\r\n?/', Option::where('name', 'emails')->value('value'));
            Mail::to($emails_arr)->send(new ConsultationMonth($all_data, $con_type, $month, $year));
            return redirect('/conf-month-gen')->with('success', 'Sėkmingai sugeneruotos ir išsiųstos mėnesio konsultacijos');
        }
    }

    public function index() {
        return view('exports.index');
    }

    public function configure(Request $request) {
        $data = $this->validate($request, [
            'ex-date' => 'required',
            'con_payment' => 'required',
            'con_type' => 'required',
            'is-sent' => 'required',
            'con-date' => 'required',
        ]);
        return $this->month(
            $request->input('ex-date'),
            $request->input('con_type'),
            $request->input('action'),
            $request->input('con_payment'),
            $request->input('is-sent'),
            $request->input('con-date')
        );
    }

}
