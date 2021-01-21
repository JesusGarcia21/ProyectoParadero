<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paraderos;
use App\Rutas;
use exception;

class ParaderosController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $paraderos = Paraderos::join('rutas', 'paraderos.id_rutas','=','rutas.id')
            ->select('paraderos.id','paraderos.id_rutas','paraderos.ubicacion','paraderos.latitud','paraderos.longitud','paraderos.condicion','rutas.id as id_rutas','rutas.ruta')
            ->orderBy('id', 'desc')->paginate(3);
        }
        else{
            $paraderos = Paraderos::join('rutas', 'paraderos.id_rutas','=','rutas.id')
            ->select('paraderos.id','paraderos.id_rutas','paraderos.ubicacion','paraderos.latitud','paraderos.longitud','paraderos.condicion','rutas.id as id_rutas','rutas.ruta')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('id', 'desc')->paginate(3);
        }
        //return $paraderos;

        return [
            'pagination' => [
                'total'        => $paraderos->total(),
                'current_page' => $paraderos->currentPage(),
                'per_page'     => $paraderos->perPage(),
                'last_page'    => $paraderos->lastPage(),
                'from'         => $paraderos->firstItem(),
                'to'           => $paraderos->lastItem(),
            ],
            'paraderos' => $paraderos
        ];
    }

    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $paraderos = new Paraderos();
        $paraderos->ubicacion = $request->ubicacion;
        $paraderos->id_rutas = $request->id_rutas;
        $paraderos->latitud = $request->latitud;
        $paraderos->longitud = $request->longitud;
        $paraderos->condicion = '1';
        $paraderos->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $paraderos = Paraderos::findOrFail($request->id);
        $paraderos->ubicacion = $request->ubicacion;
        $paraderos->id_rutas = $request->id_rutas;
        $paraderos->latitud = $request->latitud;
        $paraderos->longitud = $request->longitud;
        $paraderos->condicion = '1';
        $paraderos->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $paraderos = Paraderos::findOrFail($request->id);
        $paraderos->condicion = '0';
        $paraderos->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $paraderos = Paraderos::findOrFail($request->id);
        $paraderos->condicion = '1';
        $paraderos->save();
    }

    public function destroy($id)
    {
        $paraderos = Paraderos::where('id',$id)->delete();
    }

    public function selectRuta(Request $request)
    {
        if(!$request->ajax()) return redirect('/');
        $rutas = Rutas::select('id','ruta')
        ->orderBy('ruta','asc')->get();
        return ['rutas'=>$rutas];
    }
    public function ver()
    {
        //$rutas = Rutas::all();
        $rutas = Paraderos::join('rutas', 'paraderos.id_rutas','=','rutas.id')
        ->select('paraderos.id','paraderos.id_rutas','paraderos.latitud','paraderos.longitud','rutas.id as id_rutas','rutas.id')
        ->where('paraderos.condicion','=','1')
        ->get();
        
        return [$rutas];
    }
    public function rutas()
    {
        $rutas = Paraderos:: join('rutas', 'paraderos.id_rutas','=','rutas.id')
        ->select('paraderos.id','rutas.id as id_rutas','rutas.latitud_inicial','rutas.latitud_final','rutas.longitud_inicial','rutas.longitud_final')
        ->where('rutas.condicion','=','1')
        ->get();
        return[$rutas];
    }
}
