<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    //protected $table = 'vehiculos';
    //protected $primaryKey = 'id';
    protected $fillable = [
        'lunes','martes','miercoles','jueves','viernes','sabado','domingo','incio','fin','condicion'
    ];
   


}
