<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ubicacion;


class UbicacionController extends Controller
{

    public function store(Request $request)
    {
         
        $ubicacion = Ubicacion::create($request->all());
        return response()->json($ubicacion, 200);
    }

}
