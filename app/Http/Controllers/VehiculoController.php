<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vehiculo;
use App\Tipos;
use App\Rutas;

//use exception;

class VehiculoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $vehiculos = Vehiculo::join('rutas','vehiculos.id_ruta','=','rutas.id')
            ->select('vehiculos.id','vehiculos.id_ruta','vehiculos.id_tipo',
            'vehiculos.placa','vehiculos.conductor','vehiculos.destino','vehiculos.Condicion','rutas.ruta')
            ->orderBy('vehiculos.id','asc')->paginate(2);
        }
        else{
            $vehiculos = Vehiculo::join('rutas','vehiculos.id_rutas','=','rutas.id')
            ->select('vehiculos.id','vehiculos.id_ruta','vehiculos.id_tipo',
            'vehiculos.placa','vehiculos.conductor','vehiculos.destino','vehiculos.Condicion','rutas.ruta')
            ->where($criterio,'like','%'. $buscar .'%')
            ->orderBy('vehiculos.id','asc')->paginate(2);
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
    public function lista_vehiculos(Request $request)
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
        return['vehiculos' => $vehiculos];
    }
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $vehiculo = new Vehiculo();
        $vehiculo->id_ruta = $request->id_ruta;
        $vehiculo->id_tipo = $request->id_tipo;
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
        $vehiculo->id_ruta = $request->id_ruta;
        $vehiculo->id_tipo = $request->id_tipo;
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
    public function destroy(Request $request)
    {
        Vehiculo::destroy($request->id);
    }
    public function selectRuta(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $rutas = Rutas::select('id','ruta')
        ->orderBy('ruta','asc')->get();
        return ['rutas'=>$rutas];
    }

    public function selectTipo(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $tipos = Tipos::select('id','nombre')
        ->orderBy('nombre','asc')->get();
        return ['tipos'=>$tipos];
    }

}

    
