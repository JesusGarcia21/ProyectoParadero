<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Rutas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rutas', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_vehiculo');

            $table->string('direccion', 100);
            $table->string('ruta', 100);
            $table->string('latitud', 100);
            $table->string('longitud', 100);
            $table->boolean('condicion')->default(1);

           $table->foreign('id_vehiculo')->references('id')->on('vehiculos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rutas');
    }
}
