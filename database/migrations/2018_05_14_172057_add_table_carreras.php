<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableCarreras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    /*
        Schema::create('carreras', function (Blueprint $table) {
            $table->increments('id');
            $table->text('nombre');
            $table->text('jefe');
            $table->timestamps();
        });
    */

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       // Schema::dropIfExists('carreras');
    }
}