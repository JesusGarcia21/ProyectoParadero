<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paraderos extends Model
{
    //protected $table = 'paraderos';
    //protected $primaryKey = 'id';
    protected $fillable = ['ubicacion','ruta','serie','latitud','longitud','condicion'];
}
