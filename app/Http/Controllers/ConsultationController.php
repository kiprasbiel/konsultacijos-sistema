<?php

namespace App\Http\Controllers;

use App\Mail\ConsultationMail;
use App\Mail\ConsultationDeleteMail;
use App\User;
use Illuminate\Http\Request;
use App\Consultation;
use Illuminate\Support\Facades\Mail;
use App\Client;
use App\Theme;

class ConsultationController extends Controller
{

    public function __construct() {
        $this->middleware('auth');

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $created_by = auth()->user()->id;
        $unsent = Consultation::where('created_by', $created_by)->where('is_sent', 0)->count();
        $consultations = Consultation::where('created_by', $created_by)->orderBy('id', 'desc')->paginate(50);
        return view('consultations.index')->with('consultations', $consultations)->with('unsent', $unsent);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request) {
        $users = User::where('role', 2)->get();
        $formatted_users = [];
        foreach ($users as $user){
            $formatted_users[$user->id] =  $user->name;
        }
        if($request->session()->get('consultation_id')){
//            dd($request->session()->get('consultation_id'));
            $consultation = Consultation::find($request->session()->get('consultation_id'));
            return view('consultations.create_duplicate')->with('consultation', $consultation)->with('users', $formatted_users);
        }
        return view('consultations.create')->with('users', $formatted_users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $this->validate($request, [
            'company_id' => 'required',
            'contacts' => 'required',
            'theme' => 'required',
            'reg_county' => 'required',
            'address' => 'required',
            'consultation_date' => 'required',
            'consultation_length' => 'required',
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


        if($request->input('action') == 'duplicate') {
            $success_message = 'Nauja konsultacija sėkmingai sukurta ir laukia išsiuntimo!';
            $consultation->is_sent = 0;
            $consultation->save();

            $consultation_id = $consultation->id;
            return redirect('/konsultacijos/create')->with('consultation_id', $consultation_id)->with('notice', $success_message);
        }
        else {
            $success_message = 'Nauja konsultacija sėkmingai sukurta!';
            $consultation->is_sent = 0;

        }
        $consultation->save();

        return redirect('/konsultacijos')->with('success', $success_message);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id) {
        $users = User::where('role', 2)->get();
        $formatted_users = [];
        foreach ($users as $user){
            $formatted_users[$user->id] =  $user->name;
        }

        $consultation = Consultation::find($id);
        return view('consultations.edit')->with('consultation', $consultation)->with('users', $formatted_users);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {
        $data = $this->validate($request, [
            'company_id' => 'required',
            'contacts' => 'required',
            'theme' => 'required',
            'reg_county' => 'required',
            'address' => 'required',
            'consultation_date' => 'required',
            'consultation_length' => 'required',
            'consultation_start' => 'required',
            'method' => 'required',
            'user_id' => 'required',
            'break_start' => 'required_with:break_end',
            'break_end' => 'required_with:break_start',
        ]);

        $county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];

        $consultation_start = explode(":", $data['consultation_start']);
        if(!is_null($data['break_start']) && !is_null($data['break_end'])){
            $consultation_start_str = $consultation_start[0] . " val. " . $consultation_start[1] . " min." . "\nPertrauka " . date("H:i", strtotime($data['break_start'])) . "-" . date("H:i", strtotime($data['break_end']));
        }
        else{
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

        if (empty($changes)){
            return redirect('/konsultacijos')->with('notice', 'Konsultacija neišsiųsta, nes niekas nebuvo pakeista.');
        }

        Mail::to('test@test.com')->send(new ConsultationMail($new_data, $changes));

        $consultation->save();

        return redirect('/konsultacijos')->with('success', 'Konsultacija sėkmingai atnaujinta!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {
        $consultation = Consultation::find($id);

        $county_list = ["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."];
        $data = [
            'nr' => 1,
            'company_id' => $consultation->client->name,
            'contacts' => $consultation->contacts,
            'theme' => $consultation->theme->name,
            'address' => $consultation->address . "\n" . $county_list[$consultation->county],
            'consultation_date' => str_replace("-", ".", $consultation->consultation_date),
            'consultation_start' => " ", //siunciam tuscia, kad konsultacija neivyks
            'consultation_length' => $consultation->consultation_length,
            'method' => $consultation->method,
        ];

        Mail::to('test@test.com')->send(new ConsultationDeleteMail($data));

        $consultation->delete();

        return redirect('/konsultacijos')->with('success', 'Konsultacija ištrinta.');
    }

    public function review(){
        $not_sent = Consultation::where('is_sent', 0)->paginate(50);
        return view('exports.new_edited_consultation_review')->with('consultations', $not_sent);
    }

}
