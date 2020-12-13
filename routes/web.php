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

Route::get('/', function () {
    return view('contenido/contenido');
});



Route::get('/vehiculo', 'VehiculoController@index');
Route::post('/vehiculo/registrar', 'VehiculoController@store');
Route::put('/vehiculo/actualizar', 'VehiculoController@update');
Route::put('/vehiculo/desactivar', 'VehiculoController@desactivar');
Route::put('/vehiculo/activar', 'VehiculoController@activar');
Route::delete('/vehiculo/delete/{id}', 'VehiculoController@destroy');
Route::get('/vehiculo/selectRuta', 'VehiculoController@selectRuta');
Route::get('/vehiculo/selectTipo', 'VehiculoController@selectTipo');

Route::get('/paraderos', 'ParaderosController@index');
Route::post('/paraderos/registrar', 'ParaderosController@store');
Route::put('/paraderos/actualizar', 'ParaderosController@update');
Route::put('/paraderos/desactivar', 'ParaderosController@desactivar');
Route::put('/paraderos/activar', 'ParaderosController@activar');
Route::delete('/paraderos/delete/{id}','ParaderosController@destroy');

Route::get('/rutas', 'RutasController@index');
Route::post('/rutas/registrar', 'RutasController@store');
Route::put('/rutas/actualizar', 'RutasController@update');
Route::put('/rutas/desactivar', 'RutasController@desactivar');
Route::put('/rutas/activar', 'RutasController@activar');
Route::delete('/rutas/delete/{id}','RutasController@destroy');
Route::get('/rutas/selectPlacas', 'RutasController@selectPlacas');
Route::delete('/rutas/delete/{id}','RutasController@destroy');

Route::get('/tipos', 'TiposController@index');
Route::post('/tipos/registrar', 'TiposController@store');
Route::put('/tipos/actualizar', 'TiposController@update');
Route::put('/tipos/desactivar', 'TiposController@desactivar');
Route::put('/tipos/activar', 'TiposController@activar');
