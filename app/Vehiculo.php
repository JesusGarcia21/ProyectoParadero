<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';
    //protected $primaryKey = 'id';
    protected $fillable = ['ruta','tipo','placa','conductor','destino'];
}
