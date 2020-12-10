<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehiculo;
//use exception;

class VehiculoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $vehiculos = Vehiculo::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $vehiculos = Vehiculo::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

        return [
            'pagination' => [
                'total'        => $vehiculos->total(),
                'current_page' => $vehiculos->currentPage(),
                'per_page'     => $vehiculos->perPage(),
                'last_page'    => $vehiculos->lastPage(),
                'from'         => $vehiculos->firstItem(),
                'to'           => $vehiculos->lastItem(),
            ],
            'vehiculos' => $vehiculos
        ];
    }   

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $vehiculo = new Vehiculo();
        $vehiculo->ruta = $request->ruta;
        $vehiculo->tipo = $request->tipo;
        $vehiculo->placa = $request->placa;
        $vehiculo->conductor = $request->conductor;
        $vehiculo->destino = $request->destino;
        $vehiculo->condicion = '1';
        $vehiculo->save();
    }
  

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $vehiculo = Vehiculo::findOrFail($request->id);
        $vehiculo->ruta = $request->ruta;
        $vehiculo->tipo = $request->tipo;
        $vehiculo->placa = $request->placa;
        $vehiculo->conductor = $request->conductor;
        $vehiculo->destino = $request->destino;
        $vehiculo->condicion = '1';
        $vehiculo->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $vehiculo = Vehiculo::findOrFail($request->id);
        $vehiculo->condicion = '0';
        $vehiculo->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $vehiculo = Vehiculo::findOrFail($request->id);
        $vehiculo->condicion = '1';
        $vehiculo->save();
    }

}
