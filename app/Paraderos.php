<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paraderos extends Model
{
    //protected $table = 'paraderos';
    //protected $primaryKey = 'id';
    protected $fillable = ['id_rutas','ubicacion','latitud','longitud','condicion'];

    //Una ruta pertenece a un paradero
    public function Ruta()
    {
        return $this->belongsTo('App\rutas');
    }
}
