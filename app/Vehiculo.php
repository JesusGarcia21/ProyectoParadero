<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';
    //protected $primaryKey = 'id';
    protected $fillable = [
        'id_ruta','id_tipo','placa','conductor','destino'
    ];
   

    public function ruta()
    {
        return $this->belongsTo('App\Ruta');
    }

    //Un vehiculo pertenece a una tipo
    public function tipo()
    {
        return $this->belongsTo('App\Tipo');
    }
}
