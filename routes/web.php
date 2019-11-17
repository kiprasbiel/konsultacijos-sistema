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

//Route::get('/konsultacijos', 'ConsultationController');

Route::resource('konsultacijos', 'ConsultationController');

Route::resource('klientai', 'ClientController');

//Ajax paieska
Route::post('/search','SearchController@search')->name('search');
Route::get('/themesearch','SearchController@themeSearch');

//Paprasta paieska
Route::get('/con-search', 'SearchController@consultation_search');
Route::get('/cl-search', 'SearchController@client_search');

//Excel generavimas
Route::get('/store', 'ExcelExportController@store');

//Laisku siuntimas
Route::resource('mail', 'MailController');

//Menesio ataskaitos generavimas
Route::get('/generate-month', 'ExcelExportController@month');

//Updatina konsultacija i Paid
Route::get('/paid/{id}', 'ConsultationController@paid');

//Test routes
Route::get('ajax-test',function() {
    return view('ajax-test');
});
Route::post('/getmsg','TestAjaxController@index');
