<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rutas;
use App\Paraderos;
use exception;


class RutasController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
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
        $rutas->latitud_inicial = $request->latitud_inicial;
        $rutas->longitud_inicial = $request->longitud_inicial;
        $rutas->latitud_final = $request->latitud_final;
        $rutas->longitud_final = $request->longitud_final;
        $rutas->condicion = '1';
        $rutas->save();
    }
  
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $rutas = Rutas::findOrFail($request->id);
        $rutas->direccion = $request->direccion;
        $rutas->ruta = $request->ruta;
        $rutas->latitud_inicial = $request->latitud_inicial;
        $rutas->longitud_inicial = $request->longitud_inicial;
        $rutas->latitud_final = $request->latitud_final;
        $rutas->longitud_final = $request->longitud_final;
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


    
    public function rut()
    {
        $rutas= Rutas::select('latitud_inicial','latitud_final','longitud_inicial','longitud_final')->get();
        return [$rutas];
    }
}
