<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Imagen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('imagen', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('idcoche')->unsigned();
            $table->string('nombre', 100);
            $table->string('tipo', 20);
            $table->foreign('idcoche')->references('id')->on('coche');

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
        Schema::dropIfExists('categoria');
    }
}
