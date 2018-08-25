<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableReprobacion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reprobacion', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_carrera');
            $table->integer('id_periodo');
            $table->integer('totalRepro');
            $table->integer('totalMat');
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
        Schema::dropIfExists('reprobacion');
    }
}
