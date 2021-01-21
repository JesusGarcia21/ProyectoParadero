<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    //protected $table = 'vehiculos';
    //protected $primaryKey = 'id';
    protected $fillable = [
        'lunes','martes','miercoles','jueves','viernes','sabado','domingo','inciol','finl','inciom','finm',
        'inciomi','finmi','incioj','finj','inciov','finv','incios','fins','inciold','finld','condicion'
    ];
   


}
