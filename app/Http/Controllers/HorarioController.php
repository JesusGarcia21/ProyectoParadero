<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Horario;


//use exception;

class HorarioController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        if ($buscar==''){
            $horarios = Horario::orderBy('id', 'desc')->paginate(3);
        }
        else{
            $horarios= Horario::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(3);
        }
        
        return [
            'pagination' => [
                'total'        => $horarios->total(),
                'current_page' => $horarios->currentPage(),
                'per_page'     => $horarios->perPage(),
                'last_page'    => $horarios->lastPage(),
                'from'         => $horarios->firstItem(),
                'to'           => $horarios->lastItem(),
            ],
            'horarios' => $horarios
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
        $horarios = new Horario();
        $horarios->lunes = $request->lunes;
        $horarios->martes = $request->martes;
        $horarios->miercoles = $request->miercoles;
        $horarios->jueves = $request->jueves;
        $horarios->viernes = $request->viernes;
        $horarios->sabado = $request->sabado;
        $horarios->domingo = $request->domingo;
        $horarios->iniciol = $request->iniciol;
        $horarios->finl = $request->finl;
        $horarios->iniciom = $request->iniciom;
        $horarios->finm = $request->finm;
        $horarios->iniciomi = $request->iniciomi;
        $horarios->finmi = $request->finmi;
        $horarios->inicioj = $request->inicioj;
        $horarios->finj = $request->finj;
        $horarios->iniciov = $request->iniciov;
        $horarios->finv = $request->finv;
        $horarios->inicios = $request->inicios;
        $horarios->fins = $request->fins;
        $horarios->iniciod = $request->iniciod;
        $horarios->find = $request->find;
       $horarios->condicion = '1';
        $horarios->save();
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
        $horarios = Horario::findOrFail($request->id);
        $horarios->lunes = $request->lunes;
        $horarios->martes = $request->martes;
        $horarios->miercoles = $request->miercoles;
        $horarios->jueves = $request->jueves;
        $horarios->viernes = $request->viernes;
        $horarios->sabado = $request->sabado;
        $horarios->domingo = $request->domingo;
        $horarios->iniciol = $request->iniciol;
        $horarios->finl = $request->finl;
        $horarios->iniciom = $request->iniciom;
        $horarios->finm = $request->finm;
        $horarios->iniciomi = $request->iniciomi;
        $horarios->finmi = $request->finmi;
        $horarios->inicioj = $request->inicioj;
        $horarios->finj = $request->finj;
        $horarios->iniciov = $request->iniciov;
        $horarios->finv = $request->finv;
        $horarios->inicios = $request->inicios;
        $horarios->fins = $request->fins;
        $horarios->iniciod = $request->iniciod;
        $horarios->find = $request->find;
        $horarios->condicion = '1';
        $horarios->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $horarios = horario::findOrFail($request->id);
        $horarios->condicion = '0';
        $horarios->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $horarios = Horario::findOrFail($request->id);
        $horarios->condicion = '1';
        $horarios->save();
    }
    public function destroy(Request $request)
    {
        Horario::destroy($request->id);
    }

}

    
