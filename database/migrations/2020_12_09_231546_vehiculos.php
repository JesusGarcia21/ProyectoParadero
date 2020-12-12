<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Vehiculos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('id_ruta');
            
            $table->unsignedInteger('id_tipo');
            
            $table->Integer('placa');
            $table->string('conductor', 50);
            $table->string('destino', 50);
            $table->boolean('condicion')->default(1);

           $table->foreign('id_ruta')->references('id')->on('rutas');
            $table->foreign('id_tipo')->references('id')->on('tipos');
         
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
        Schema::drop('Vehiculos');
    }
}
