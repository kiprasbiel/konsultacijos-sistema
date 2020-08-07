<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::resource('konsultacijos', 'ConsultationController');

Route::resource('klientai', 'ClientController');

//Ajax paieska
Route::get('/search', 'SearchController@search')->name('search');
Route::get('/search/{id}', 'SearchController@searchid');
Route::get('/themesearch', 'SearchController@themeSearch');
Route::post('/theme-list-update', 'SearchController@themeListSearch');

//Paprasta paieska
Route::get('/table-search', 'ConsultationController@display_table_search_results');
Route::get('/table-search-client', 'ClientController@display_table_search_results');

//Excel generavimas
//Anksciau budavo kreipimasis tiesiai is konsultaciju index view
Route::post('/store', 'ExcelExportController@store');

//Menesio ataskaitos generavimas
Route::get('/conf-month-gen', 'ExcelExportController@index');
Route::post('/configure', 'ExcelExportController@configure');

//Updatina konsultacija i Paid
Route::get('/paid/{id}', 'ConsultationController@paid');

//Apmokejimai
Route::get('/apmokejimai', 'PaymentController@index');
Route::put('/apmokejimai/update', 'PaymentController@update');

//Konsultantai ir kiti vartotojai
Route::get('/vartotojai', 'UserController@index');
Route::get('/create-user', 'UserController@create');
Route::get('/vartotojai/{id}/edit', 'UserController@edit');
Route::put('/vartotojai/{id}/', 'UserController@update');
Route::delete('/vartotojai/{id}/', 'UserController@destroy');

//Nauju ir redaguotu konsultaciju siuntimo logika
Route::get('/review', 'ConsultationController@review');
Route::post('/send-reviewed', 'ExcelExportController@send_reviewed');

Route::get('/settings', 'SettingsController@index');
Route::match(['put', 'post', 'patch'], '/settings/email', 'SettingsController@set_options');

//Table sorting
Route::post('/sort-table', 'ClientController@list_sort');

//Import
Route::get('/import', 'ImportController@index');
Route::post('/import', 'ImportController@import');
Route::post('/import-save', 'ImportController@save');

//TODO: DELETE AFTER USING
//Migrating consultations breaks to constulation_metas table
Route::get('/migrate', function () {
//    $consultations = \App\Consultation::whereNotNull('break_start')->whereNotNull('break_end')->get();
//    foreach ($consultations as $consultation) {
//        $start = $consultation->break_start;
//        $end = $consultation->break_end;
//        $id = $consultation->id;
//        echo($start . ' ' . $end . ' ' . $id . '<br>');
//
//        $meta = new \App\Consultation_meta();
//
//        $meta->consultation_id = $id;
//        $meta->type = 'consultation_break';
//        $meta->value = json_encode([
//            [
//                'break_start' => $start,
//                'break_end' => $end,
//            ]
//        ]);
//        $meta->save();
//    }

    $meta = \App\Consultation_meta::find(1665);

    $json = json_encode([
        [
            'break_start' => "18:00",
            'break_end' => "18:30",
        ],
        [
            'break_start' => "19:00",
            'break_end' => "19:30",
        ]
    ]);

    $meta->value = $json;
    $meta->save();

}
);
