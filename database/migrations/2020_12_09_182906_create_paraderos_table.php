<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParaderosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('paraderos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ubicacion', 100);
            $table->string('ruta', 100);
            $table->string('serie', 100);
            $table->string('latitud', 100);
            $table->string('longitud', 100);
            $table->boolean('condicion')->default(1);
            $table->timestamps();
            //$table->string('descripcion', 256)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('paraderos');
    }
}
