<?php

use App\Theme;
use Illuminate\Database\Seeder;

class ThemesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $themes = array(
            array('id' => '1','name' => 'Atliekų perdirbimas ir antrinis panaudojimas gamyboje','main_theme' => 'ECO','theme_number' => '1','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => NULL,'type' => NULL),
            array('id' => '2','name' => 'Ekologinis gaminių projektavimas','main_theme' => 'ECO','theme_number' => '2','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => NULL,'type' => NULL),
            array('id' => '3','name' => 'Taršos prevencija','main_theme' => 'ECO','theme_number' => '3','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => NULL,'type' => NULL),
            array('id' => '4','name' => 'Ekoinovacijų diegimas','main_theme' => 'ECO','theme_number' => '4','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => NULL,'type' => NULL),
            array('id' => '5','name' => 'Aplinkosaugos vadybos sistemų diegimas','main_theme' => 'ECO','theme_number' => '5','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => NULL,'type' => NULL),
            array('id' => '6','name' => 'Pasirengimo eksportui veiksmų planas','main_theme' => 'EXPO','theme_number' => '1','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => '3','type' => 'IKI3'),
            array('id' => '7','name' => 'Eksporto strategija','main_theme' => 'EXPO','theme_number' => '2','created_at' => NULL,'updated_at' => NULL,'min_old' => '3','max_old' => NULL,'type' => 'PO3'),
            array('id' => '8','name' => 'Tikslinių eksporto rinkų pasirinkimas ir išorinė komunikacija','main_theme' => 'EXPO','theme_number' => '3','created_at' => NULL,'updated_at' => NULL,'min_old' => '3','max_old' => NULL,'type' => 'PO3'),
            array('id' => '9','name' => 'Tarptautinės prekybos teisiniai aspektai ir sertifikavimas užsienio rinkose','main_theme' => 'EXPO','theme_number' => '4','created_at' => NULL,'updated_at' => NULL,'min_old' => '3','max_old' => NULL,'type' => 'PO3'),
            array('id' => '10','name' => 'Techniniai ir gamybiniai eksporto aspektai','main_theme' => 'EXPO','theme_number' => '5','created_at' => NULL,'updated_at' => NULL,'min_old' => '3','max_old' => NULL,'type' => 'PO3'),
            array('id' => '11','name' => 'Eksporto rizikos valdymas','main_theme' => 'EXPO','theme_number' => '6','created_at' => NULL,'updated_at' => NULL,'min_old' => '3','max_old' => NULL,'type' => 'PO3'),
            array('id' => '12','name' => 'Verslo planavimas','main_theme' => 'VKT','theme_number' => '1','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => '1','type' => 'PR'),
            array('id' => '13','name' => 'Mokesčiai ir buhalterinė apskaita','main_theme' => 'VKT','theme_number' => '2','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => '1','type' => 'PR'),
            array('id' => '14','name' => 'Parama verslui, verslo finansavimo šaltiniai','main_theme' => 'VKT','theme_number' => '3','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => '1','type' => 'PR'),
            array('id' => '15','name' => 'Produkto, paslaugos tobulinimas','main_theme' => 'VKT','theme_number' => '4','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => '1','type' => 'PR'),
            array('id' => '16','name' => 'Pardavimas','main_theme' => 'VKT','theme_number' => '5','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => '1','type' => 'PR'),
            array('id' => '17','name' => 'Rinkodara','main_theme' => 'VKT','theme_number' => '6','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => '1','type' => 'PR'),
            array('id' => '18','name' => 'Sutarčių sudarymas ir valdymas','main_theme' => 'VKT','theme_number' => '7','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => '1','type' => 'PR'),
            array('id' => '19','name' => 'Dokumentų rengimas ir valdymas','main_theme' => 'VKT','theme_number' => '8','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => '1','type' => 'PR'),
            array('id' => '20','name' => 'Personalo valdymas, darbo teisė ir sauga','main_theme' => 'VKT','theme_number' => '9','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => '1','type' => 'PR'),
            array('id' => '21','name' => 'Socialinis verslas','main_theme' => 'VKT','theme_number' => '10','created_at' => NULL,'updated_at' => NULL,'min_old' => NULL,'max_old' => '1','type' => 'PR'),
            array('id' => '22','name' => 'Įmonės strategija','main_theme' => 'VKT','theme_number' => '11','created_at' => NULL,'updated_at' => NULL,'min_old' => '1','max_old' => '5','type' => 'PL'),
            array('id' => '23','name' => 'Įmonės veiklos procesai ir veiklos efektyvumas','main_theme' => 'VKT','theme_number' => '12','created_at' => NULL,'updated_at' => NULL,'min_old' => '1','max_old' => '5','type' => 'PL'),
            array('id' => '24','name' => 'Rinkodara, įmonės įvaizdžio formavimas','main_theme' => 'VKT','theme_number' => '13','created_at' => NULL,'updated_at' => NULL,'min_old' => '1','max_old' => '5','type' => 'PL'),
            array('id' => '25','name' => 'Įmonės finansų valdymas','main_theme' => 'VKT','theme_number' => '14','created_at' => NULL,'updated_at' => NULL,'min_old' => '1','max_old' => '5','type' => 'PL'),
            array('id' => '26','name' => 'Pardavimas ir derybos','main_theme' => 'VKT','theme_number' => '15','created_at' => NULL,'updated_at' => NULL,'min_old' => '1','max_old' => '5','type' => 'PL'),
            array('id' => '27','name' => 'Investicijos ir finansavimo šaltiniai','main_theme' => 'VKT','theme_number' => '16','created_at' => NULL,'updated_at' => NULL,'min_old' => '1','max_old' => '5','type' => 'PL'),
            array('id' => '28','name' => 'Teisiniai aspektai','main_theme' => 'VKT','theme_number' => '17','created_at' => NULL,'updated_at' => NULL,'min_old' => '1','max_old' => '5','type' => 'PL'),
            array('id' => '29','name' => 'Projektų valdymas','main_theme' => 'VKT','theme_number' => '18','created_at' => NULL,'updated_at' => NULL,'min_old' => '1','max_old' => '5','type' => 'PL'),
            array('id' => '30','name' => 'Socialinis verslas','main_theme' => 'VKT','theme_number' => '19','created_at' => NULL,'updated_at' => NULL,'min_old' => '1','max_old' => '5','type' => 'PL')
        );

        Theme::truncate();

        foreach ($themes as $theme) {
            Theme::create($theme);
        }
    }
}
