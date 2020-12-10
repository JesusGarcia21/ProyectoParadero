<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rutas extends Model
{
    //protected $table = 'rutas';
    //protected $primaryKey = 'id';
    protected $fillable = ['direccion','ruta','latitud','longitud','condicion'];
}
