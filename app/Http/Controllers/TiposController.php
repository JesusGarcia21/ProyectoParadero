<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tipos;


class TiposController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $tipos = Tipos::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $tipos = Tipos::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }

        return [
            'pagination' => [
                'total'        => $tipos->total(),
                'current_page' => $tipos->currentPage(),
                'per_page'     => $tipos->perPage(),
                'last_page'    => $tipos->lastPage(),
                'from'         => $tipos->firstItem(),
                'to'           => $tipos->lastItem(),
            ],
            'tipos' => $tipos
        ];
    }   

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); 
        $tipos = new Tipos();
        $tipos->nombre = $request->nombre;
      //  $tipo->condicion = '1';
        $tipos->save();
    }
  
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $tipos = Tipos::findOrFail($request->id);
        $tipos->nombre = $request->nombre;

        $tipos->condicion = '1';
        $tipos->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $tipos = Tipos::findOrFail($request->id);
        $tipos->condicion = '0';
        $tipos->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $tipos = Tipos::findOrFail($request->id);
        $tipos->condicion = '1';
        $tipos->save();
    }
}
