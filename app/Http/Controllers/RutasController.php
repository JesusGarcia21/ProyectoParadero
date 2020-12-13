<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rutas;
use App\Vehiculo;
use exception;


class RutasController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        /*if ($buscar==''){
            $rutas = Rutas::join('vehiculos','rutas.id','=','vehiculos.id')
            ->select('rutas.id','rutas.direccion','rutas.ruta','rutas,latitud','rutas.longitud','rutas.condicion')
            ->orderBy('rutas.id','asc')->paginate(2);
        }
        else{
            $rutas = Rutas::join('vehiculos','rutas.id','=','vehiculos.id')
            ->select('rutas.id','rutas.direccion','rutas.ruta','rutas,latitud','rutas.longitud','rutas.condicion')
            ->where($criterio,'like','%'. $buscar .'%')
            ->orderBy('rutas.id','asc')->paginate(2);
        }*/

       if ($buscar==''){
            $rutas = Rutas::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $rutas = Rutas::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }

        return [
            'pagination' => [
                'total'        => $rutas->total(),
                'current_page' => $rutas->currentPage(),
                'per_page'     => $rutas->perPage(),
                'last_page'    => $rutas->lastPage(),
                'from'         => $rutas->firstItem(),
                'to'           => $rutas->lastItem(),
            ],
            'rutas' => $rutas
        ];
    }   

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $rutas = new Rutas();
        $rutas->direccion = $request->direccion;
        $rutas->ruta = $request->ruta;
        $rutas->latitud = $request->latitud;
        $rutas->longitud = $request->longitud;
        $rutas->condicion = '1';
        $rutas->save();
    }
  
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $rutas = Rutas::findOrFail($request->id);
        $rutas->direccion = $request->direccion;
        $rutas->ruta = $request->ruta;
        $rutas->latitud = $request->latitud;
        $rutas->longitud = $request->longitud;
        $rutas->condicion = '1';
        $rutas->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $rutas = Rutas::findOrFail($request->id);
        $rutas->condicion = '0';
        $rutas->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $rutas = Rutas::findOrFail($request->id);
        $rutas->condicion = '1';
        $rutas->save();
    }

    public function destroy($id)
    {
        $rutas = Rutas::where('id',$id)->delete();
    }

    public function selectPlacas(Request $request)
    {
        //if(!$request->ajax()) return redirect('/');
        $vehiculo = Vehiculo::select('id','placa')
        ->orderBy('placa','asc')->get();
        return ['placas'=>$vehiculo];
    }
}
