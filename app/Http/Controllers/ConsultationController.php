<?php

namespace App\Http\Controllers;

use App\Consultation_meta;
use App\CustomClasses\SearchTableColumns;
use App\CustomClasses\TableSort;
use App\Mail\ConsultationMail;
use App\Mail\ConsultationDeleteMail;
use App\Option;
use App\Rules\AfterTomorrow;
use App\Rules\ValidConsultationDate;
use App\User;
use Illuminate\Http\Request;
use App\Consultation;
use Illuminate\Support\Facades\Mail;
use App\Client;
use App\Theme;
use Carbon\Carbon;

class ConsultationController extends Controller
{

    private $pagination_int;

    public function __construct() {
        $this->middleware('auth');
        $this->pagination_int = Option::where('name', 'pagination_per_page')->value('value');
    }

    public function index(Request $request) {
        $column = 'id';
        $column_sort = 'desc';

        $created_by = auth()->user()->id;
        $unsent = Consultation::where('created_by', $created_by)->where('is_sent', 0)->count();

        if ($request->column !== null && $request->sort !== null) {
            $sorting = new TableSort;
            $consultations = $sorting->sort_model('Consultation', $request->input('column'), $request->input('sort'));
//            $consultations = $sorting->sort_model('Consultation', $request->input('column'), $request->input('sort'), ['created_by' => $created_by]);
            $pagination_sort = $request->input('sort');
            $column =  $request->input('column');
            $column_sort = $sorting->sort_toggle($request->input('sort'));
        }
        else{
            $consultations = Consultation::orderBy('id', 'desc')->paginate($this->pagination_int);
//            $consultations = Consultation::where('created_by', $created_by)->orderBy('id', 'desc')->paginate($this->pagination_int);
            return view('consultations.index')
                ->with('consultations', $consultations)
                ->with('unsent', $unsent)
                ->with('column_sort', $column_sort);
        }

        return view('consultations.index')
            ->with('consultations', $consultations)
            ->with('unsent', $unsent)
            ->with('column_sort', $column_sort)
            ->with('pagination_sort', $pagination_sort)
            ->with('pagination_column', $column);
    }


    public function create(Request $request) {
        $users = User::where('role', 2)->get();
        $formatted_users = [];
        foreach ($users as $user) {
            $formatted_users[$user->id] = $user->name;
        }
        if ($request->session()->get('consultation_id')) {
            $consultation = Consultation::find($request->session()->get('consultation_id'));
            return view('consultations.create_duplicate')->with('consultation', $consultation)->with('users', $formatted_users)->with('is_old_bup', $request->session()->get('is_old_bup'));
        }
        return view('consultations.create')->with('users', $formatted_users);
    }


    public function store(Request $request) {
        $data = $this->validate($request, [
            'company_id' => 'required',
            'contacts' => 'required',
            'theme' => 'required',
            'reg_county' => 'required',
            'address' => 'required',
            'consultation_date' => ['required', 'date', new AfterTomorrow($request->input('old')), new ValidConsultationDate($request->input('old'))],
            'consultation_length' => ['required'],
            'consultation_start' => 'required',
            'method' => 'required',
            'user_id' => 'required',
            'break_start' => 'required_with:break_end',
            'break_end' => 'required_with:break_start',
        ]);

        $county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];

        $consultation_start = explode(":", $data['consultation_start']);

        $consultation = new Consultation;
        $consultation->client_id = $request->input('company_id');
        $consultation->user_id = $request->input('user_id');
        $consultation->contacts = $request->input('contacts');
        $consultation->theme_id = $request->input('theme');
        $consultation->county = $request->input('reg_county');
        $consultation->address = $request->input('address');
        $consultation->consultation_date = $request->input('consultation_date');
        $consultation->consultation_time = $request->input('consultation_start');
        $consultation->consultation_length = $request->input('consultation_length');
        $consultation->method = $request->input('method');
        $consultation->is_paid = 0;
        $consultation->created_by = auth()->user()->id;
        $consultation->break_start = $request->input('break_start');
        $consultation->break_end = $request->input('break_end');

        if ($request->input('old') == 'on') {
            $consultation->is_sent = 1;
        } else {
            $consultation->is_sent = 0;
        }


        if ($request->input('action') == 'duplicate') {
            $success_message = 'Nauja konsultacija sėkmingai sukurta ir laukia išsiuntimo!';
            $consultation->save();

            $consultation_id = $consultation->id;

            return redirect('/konsultacijos/create')
                ->with('consultation_id', $consultation_id)
                ->with('notice', $success_message)
                ->with('is_old_bup', $request->input('old'));
        } else {
            $success_message = 'Nauja konsultacija sėkmingai sukurta!';

        }
        $consultation->save();

        return redirect('/konsultacijos')->with('success', $success_message);
    }


    public function show($id) {
        $users = User::where('role', 2)->get();
        $formatted_users = [];
        foreach ($users as $user) {
            $formatted_users[$user->id] = $user->name;
        }

        $consultation = Consultation::find($id);
        return view('consultations.single')->with('consultation', $consultation)->with('users', $formatted_users);
    }


    public function edit($id) {
        $users = User::where('role', 2)->get();
        $formatted_users = [];
        foreach ($users as $user) {
            $formatted_users[$user->id] = $user->name;
        }

        $consultation = Consultation::find($id);
        return view('consultations.edit')->with('consultation', $consultation)->with('users', $formatted_users);
    }


    public function update(Request $request, $id) {
        $data = $this->validate($request, [
            'company_id' => 'required',
            'contacts' => 'required',
            'theme' => 'required',
            'reg_county' => 'required',
            'address' => 'required',
            'consultation_date' => ['required', 'date'],
            'consultation_length' => 'required',
            'consultation_start' => 'required',
            'method' => 'required',
            'user_id' => 'required',
            'break_start' => 'required_with:break_end',
            'break_end' => 'required_with:break_start',
        ]);

        $county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];

        $consultation_start = explode(":", $data['consultation_start']);
        if (!is_null($data['break_start']) && !is_null($data['break_end'])) {
            $consultation_start_str = $consultation_start[0] . " val. " . $consultation_start[1] . " min." . "\nPertrauka " . date("H:i", strtotime($data['break_start'])) . "-" . date("H:i", strtotime($data['break_end']));
        } else {
            $consultation_start_str = $consultation_start[0] . " val. " . $consultation_start[1] . " min.";
        }

        $new_data = [
            'nr' => 1,
            'company_id' => Client::find($data['company_id'])->name,
            'contacts' => $data['contacts'],
            'theme' => Theme::find($data['theme'])->name . "\n(" . User::find($data['user_id'])->name . ")",
            'address' => $data['address'] . "\n" . $county_list[$data['reg_county']],
            'consultation_date' => str_replace("-", ".", $data['consultation_date']),
            'consultation_start' => $consultation_start_str,
            'consultation_length' => $data['consultation_length'],
            'method' => $data['method'],
        ];
        $consultation = Consultation::find($id);
        $consultation->client_id = $request->input('company_id');
        $consultation->user_id = $request->input('user_id');
        $consultation->contacts = $request->input('contacts');
        $consultation->theme_id = $request->input('theme');
        $consultation->county = $request->input('reg_county');
        $consultation->address = $request->input('address');
        $consultation->consultation_date = $request->input('consultation_date');
        $consultation->consultation_time = $request->input('consultation_start');
        $consultation->consultation_length = $request->input('consultation_length');
        $consultation->method = $request->input('method');
        $consultation->break_start = $request->input('break_start');
        $consultation->break_end = $request->input('break_end');

        //Gaunami laukai, kurie pasikeite
        $changes = array_keys($consultation->getDirty());
        if (empty($changes) && $consultation->consultation_meta->where('type', 'draft_changes')->first() == null) {
            return redirect('/konsultacijos')->with('notice', 'Konsultacija neišsiųsta/neatnaujinta, nes niekas nebuvo pakeista.');
        } elseif (empty($changes) && $consultation->consultation_meta->where('type', 'draft_changes')->first() != null) {
            $values = $consultation->consultation_meta->where('type', 'draft_changes')->first()->value;
            $changes = explode(', ', $values);
        }

        $emails_arr = preg_split('/\n|\r\n?/', Option::where('name', 'emails')->value('value'));

        //Tikrinama ar konsultacija jau praejus
        if ($consultation->is_con_over() == false && $consultation->is_sent == 1 && $request->input('action') == 'update') {
            $emails_arr = preg_split('/\n|\r\n?/', Option::where('name', 'emails')->value('value'));

            //Sutvarkoma struktura pries pateikiant rasymui i Excel
            $main_theme = Theme::find($data['theme'])->main_theme;
            $tarpine_arr = [];
            array_push($tarpine_arr, $new_data);
            $data_arr[$main_theme] = $tarpine_arr;

            Mail::to($emails_arr)->send(new ConsultationMail($data_arr, $changes));
            $consultation->email_sent_at = Carbon::now();

        } elseif ($request->input('action') == 'draft') {
            $this->create_meta($id, 'draft_changes', $changes);
            $consultation->save();
            return redirect('/konsultacijos')->with('success', 'Konsultacijos juodraštis sėkmingai išsaugotas!');
        }

        if ($request->input('action') == 'update') {
            if ($consultation->consultation_meta->first() !== null){
                $this->destroy_meta($consultation->consultation_meta->first()->id);
            }
        }
        $consultation->save();

        return redirect('/konsultacijos')->with('success', 'Konsultacija sėkmingai atnaujinta!');
    }


    public function destroy($id) {
        $consultation = Consultation::find($id);
        $con_main_theme = $consultation->theme->main_theme;

        $county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];
        $data = [
            'nr' => 1,
            'company_id' => $consultation->client->name,
            'contacts' => $consultation->contacts,
            'theme' => $consultation->theme->name  . "\n(" . $consultation->user->name . ")",
            'address' => $consultation->address . "\n" . $county_list[$consultation->county],
            'consultation_date' => str_replace("-", ".", $consultation->consultation_date),
            'consultation_start' => " ", //siunciam tuscia, kad konsultacija neivyks
            'consultation_length' => $consultation->consultation_length,
            'method' => $consultation->method,
        ];

        //Tikrinama ar konsultacija jau praejus
        if ($consultation->is_con_over() == false && $consultation->is_sent == 1) {
            $emails_arr = preg_split('/\n|\r\n?/', Option::where('name', 'emails')->value('value'));
            Mail::to($emails_arr)->send(new ConsultationDeleteMail($data, $con_main_theme));
        }

        $consultation->delete();

        return redirect('/konsultacijos')->with('success', 'Konsultacija ištrinta.');
    }

    public function review() {
        $not_sent = Consultation::where('is_sent', 0)->paginate(50);
        return view('exports.new_edited_consultation_review')->with('consultations', $not_sent);
    }

    public function create_meta($id, $type, $value) {
        //Tikrinama ar meta irasas jau egzistuoja
        $consultation_meta = Consultation_meta::where('consultation_id', $id)->where('type', $type)->first();
        if ($consultation_meta == null) {
            //Kuriama naujas meta irasas
            $consultation_meta = new Consultation_meta;
            $consultation_meta->consultation_id = $id;
            $consultation_meta->type = $type;
            $consultation_meta->value = implode(', ', $value);
        } else {
            $old_values = $consultation_meta->value;
            $old_values_arr = explode(', ', $old_values);
            $combined_values = array_merge($old_values_arr, $value);
            $consultation_meta->value = implode(', ', $combined_values);
        }
        $consultation_meta->save();
    }

    public function destroy_meta($id) {
        $consultation_meta = Consultation_meta::find($id);
        $consultation_meta->delete();
    }

    public static function color_index_table($id, $column) {
        $consultation_meta = Consultation_meta::where('consultation_id', $id)
            ->where('type', 'draft_changes')
            ->where('value', 'like', '%' . $column . '%')->first();
        if ($consultation_meta != null) {
            return 'background-color: #ffff005e';
        } else {
            return '';
        }
    }

    public function display_table_search_results(Request $request){
        $searchTableColumns = new SearchTableColumns();
        $consultations = $searchTableColumns->tableSearchColumn($request->model, $request->column, $request->search);

        $created_by = auth()->user()->id;
        $unsent = Consultation::where('created_by', $created_by)->where('is_sent', 0)->count();

        return view('consultations.index')
            ->with('consultations', $consultations)
            ->with('unsent', $unsent)
            ->with('column_sort', 'desc')
            ->with('table_search_model', $request->model)
            ->with('table_search_column', $request->column)
            ->with('table_search', $request->search);
    }

}
