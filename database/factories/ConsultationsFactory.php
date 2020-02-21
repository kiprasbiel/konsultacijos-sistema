<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Client;
use App\Consultation;
use App\User;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Consultation::class, function (Faker $faker) {
    $client_id = Client::get('id')->toArray();
    $formatted_client_ids = array_column($client_id, 'id');

    $users_id = User::get('id')->toArray();
    $formatted_user_ids = array_column($users_id, 'id');

    $weekAfter = Carbon::now('Europe/Vilnius')->addDays(7)->format('Y-m-d');

    $county_arr = array_keys(["akmenes-r" => "Akmenės r.", "alytaus-m" => "Alytaus m.", "alytaus-r" => "Alytaus r.", "anyksciu-r" => "Anykščių r.", "birstono" => "Birštono", "birzu-r" => "Biržų r.", "druskininku" => "Druskininkų", "elektrenu" => "Elektrėnų", "ignalinos-r" => "Ignalinos r.", "jonavos-r" => "Jonavos r.", "joniskio-r" => "Joniškio r.", "jurbarko-r" => "Jurbarko r.", "kaisiadoriu-r" => "Kaišiadorių r.", "kalvarijos" => "Kalvarijos", "kauno-m" => "Kauno m.", "kauno-r" => "Kauno r.", "kazlu-rudos" => "Kazlų Rūdos", "kelmes-r" => "Kelmės r.", "kedainiu-r" => "Kėdainių r.", "klaipedos-m" => "Klaipėdos m.", "klaipedos-r" => "Klaipėdos r.", "kretingos-r" => "Kretingos r.", "kupiskio-r" => "Kupiškio r.", "lazdiju-r" => "Lazdijų r.", "marijampoles" => "Marijampolės", "mazeikiu-r" => "Mažeikių r.", "moletu-r" => "Molėtų r.", "neringos" => "Neringos", "pagegiu" => "Pagėgių", "pakruojo-r" => "Pakruojo r.", "palangos-m" => "Palangos m.", "panevezio-m" => "Panevėžio m.", "panevezio-r" => "Panevėžio r.", "pasvalio-r" => "Pasvalio r.", "plunges-r" => "Plungės r.", "prienu-r" => "Prienų r.", "radviliskio-r" => "Radviliškio r.", "raseiniu-r" => "Raseinių r.", "rietavo" => "Rietavo", "rokiskio-r" => "Rokiškio r.", "skuodo-r" => "Skuodo r.", "sakiu-r" => "Šakių r.", "salcininku-r" => "Šalčininkų r.", "siauliu-m" => "Šiaulių m.", "siauliu-r" => "Šiaulių r.", "silales-r" => "Šilalės r.", "silutes-r" => "Šilutės r.", "sirvintu-r" => "Širvintų r.", "svencioniu-r" => "Švenčionių r.", "taurages-r" => "Tauragės r.", "telsiu-r" => "Telšių r.", "traku-r" => "Trakų r.", "ukmerges-r" => "Ukmergės r.", "utenos-r" => "Utenos r.", "varenos-r" => "Varėnos r.", "vilkaviskio-r" => "Vilkaviškio r.", "vilniaus-m" => "Vilniaus m.", "vilniaus-r" => "Vilniaus r.", "visagino-m" => "Visagino m.", "zarasu-r" => "Zarasų r."]);

    return [
        'client_id' => $faker->randomElement($formatted_client_ids),
        'user_id' => $faker->randomElement($formatted_user_ids),
        'contacts' => $faker->email,
        'theme_id' => $faker->numberBetween(1, 30),
        'address' => $faker->streetAddress,
        'consultation_date' => $weekAfter,
        'consultation_length' => $faker->time(),
        'Method' => $faker->randomElement(['Skype', 'Telefonu', 'Vietoje']),
        'county' => $faker->randomElement($county_arr),
        'is_sent' => $faker->randomElement([0, 1]),
        'is_paid' => $faker->randomElement([0, 1]),
        'created_by' => $faker->randomElement($formatted_user_ids),
        'break_start' => $faker->time(),
        'break_end' => $faker->time(),
        'consultation_time' =>$faker->time(),
    ];
});
