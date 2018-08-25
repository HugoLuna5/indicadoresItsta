<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableTitulacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
        Schema::create('titulacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_carrera');
            $table->integer('id_periodo');
            $table->integer('total');
            $table->text('periodoEgre');
            $table->timestamps();
        });
         * **/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('titulacion');
    }
}
