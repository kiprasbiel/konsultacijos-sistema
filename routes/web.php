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
Route::post('/themesearch','SearchController@themeSearch');
Route::post('/theme-list-update','SearchController@themeListSearch');

//Paprasta paieska
Route::get('/con-search', 'SearchController@consultation_search');
Route::get('/cl-search', 'SearchController@client_search');

//Excel generavimas
//Anksciau budavo kreipimasis tiesiai is konsultaciju index view
Route::post('/store', 'ExcelExportController@store');

//Laisku siuntimas
Route::resource('mail', 'MailController');

//Menesio ataskaitos generavimas
Route::get('/conf-month-gen', 'ExcelExportController@index');
Route::post('/configure', 'ExcelExportController@configure');
//Route::get('/generate-month', 'ExcelExportController@month');

//Updatina konsultacija i Paid
Route::get('/paid/{id}', 'ConsultationController@paid');

//Apmokejimai
Route::get('/apmokejimai', 'PaymentController@index');
Route::put('/apmokejimai/update', 'PaymentController@update');

//Konsultantai
Route::get('/vartotojai', 'UserController@index');
Route::get('/create-user', 'UserController@create');

//Nauju ir redaguotu konsultaciju siuntimo logika
Route::get('/review', 'ConsultationController@review');
Route::post('/send-reviewed', 'ExcelExportController@send_reviewed');