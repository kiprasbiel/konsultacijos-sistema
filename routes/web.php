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
Route::post('/search','SearchController@search')->name('search');
Route::post('/themesearch','SearchController@themeSearch');
Route::post('/theme-list-update','SearchController@themeListSearch');

//Paprasta paieska
Route::post('/table-search', 'ConsultationController@display_table_search_results');
Route::post('/table-search-client', 'ClientController@display_table_search_results');

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
Route::match(['put', 'post', 'patch'],'/settings/email', 'SettingsController@set_options');

//Table sorting
Route::post('/sort-table', 'ClientController@list_sort');
