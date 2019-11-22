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

header('Access-Control-Allow-Origin:  *');
header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
header('Access-Control-Allow-Headers:  Content-Type, X-Auth-Token, Origin, Authorization');


Route::get('/', 'HomeController@index');

Auth::routes();

Route::group(['middleware' => 'auth'], function () {
  Route::get('/home', 'HomeController@index');

  /* Servicios */
  Route::get('servicios_all', 'UserServicioController@index');
  Route::get('servicio/{id}/consulter', 'UserServicioController@consulter');
  Route::get('servicio/{id}/consuasignar', 'UserServicioController@conasignar');
  Route::post('servicio/{id}/asignar', 'UserServicioController@assign');

  Route::get('servicio/nouveau', 'ServicioController@create');
  Route::get('servicio/{id}/ver', 'ServicioController@ver');
  Route::post('servicio/enregistrer', 'ServicioController@store');
  Route::get('servicio/{id}/terminado', 'ServicioController@changeEtatToTerminado');
  Route::get('servicio/{id}/show', 'ServicioController@show');
  Route::get('/admin/tickets/export/xls', 'ServicioController@export_xls');

  //Route::get('users/filters','UsersController@index');
  Route::get('users_all', 'UsersController@show');
  Route::get('users/nouveau', 'UsersController@create');
  Route::post('users/enregistrer', 'UsersController@store');
  Route::get('users/edit/{user}', 'UsersController@edit');
  Route::put('users/enactualizar/{user}', 'UsersController@update');
  Route::delete('users/delete/{user}', 'UsersController@destroy');

  //Route::get('')

  /* Traitemnts */
  Route::get('servicio/{id}/traiter', 'TraitementController@create');
  Route::post('traitement/enregistrer', 'TraitementController@store');
});

Route::get('/api/tickets', function () {
  return \App\Ticket::All();
});
