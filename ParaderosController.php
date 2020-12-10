<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Paraderos;
use exception;

class ParaderosController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $paraderos = Paraderos::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $paraderos = Paraderos::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        

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
        $paraderos->ruta = $request->ruta;
        $paraderos->serie = $request->serie;
        $paraderos->latitud = $request->latitud;
        $paraderos->longitud = $request->ubicacion;
        $paraderos->condicion = '1';
        $paraderos->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $paraderos = Paraderos::findOrFail($request->id);
        $paraderos->ubicacion = $request->ubicacion;
        $paraderos->ruta = $request->ruta;
        $paraderos->serie = $request->serie;
        $paraderos->latitud = $request->latitud;
        $paraderos->longitud = $request->ubicacion;
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
}
