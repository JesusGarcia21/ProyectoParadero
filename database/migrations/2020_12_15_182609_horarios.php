<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Horarios extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->increments('id');
            $table->string('lunes',50)->nullable();
            $table->string('martes',50)->nullable();
            $table->string('miercoles',50)->nullable();
            $table->string('jueves',50)->nullable();
            $table->string('viernes',50)->nullable();
            $table->string('sabado',50)->nullable();
            $table->string('domingo',50);
            $table->time('iniciol', $precision = 0);
            $table->time('finl', $precision = 0);
            $table->time('iniciom', $precision = 0);
            $table->time('finm', $precision = 0);
            $table->time('iniciomi', $precision = 0);
            $table->time('finmi', $precision = 0);
            $table->time('inicioj', $precision = 0);
            $table->time('finj', $precision = 0);
            $table->time('iniciov', $precision = 0);
            $table->time('finv', $precision = 0);
            $table->time('inicios', $precision = 0);
            $table->time('fins', $precision = 0);
            $table->time('iniciod', $precision = 0);
            $table->time('find', $precision = 0);
            $table->boolean('condicion')->default(1);

        
         
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
        //
    }
}
