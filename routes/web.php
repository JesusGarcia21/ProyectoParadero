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

Route::get('/categoria', 'CategoriaController@index');
Route::post('/categoria/registrar', 'CategoriaController@store');
Route::put('/categoria/actualizar', 'CategoriaController@update');
Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
Route::put('/categoria/activar', 'CategoriaController@activar');

Route::get('/vehiculo', 'VehiculoController@index');
Route::post('/vehiculo/registrar', 'VehiculoController@store');
Route::put('/vehiculo/actualizar', 'VehiculoController@update');
Route::put('/vehiculo/desactivar', 'VehiculoController@desactivar');
Route::put('/vehiculo/activar', 'VehiculoController@activar');
