<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ubicacion extends Model
{
  //protected $table = 'tipos';
    protected $primaryKey = 'id';
    protected $fillable = [
        'ubicacion'
    ];



}
