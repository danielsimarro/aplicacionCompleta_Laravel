<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTipocategoriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipocategoria', function (Blueprint $table) {
            $table->id();
            
            //idcategoria, idcoche
            $table->bigInteger('idcategoria')->unsigned();
            $table->bigInteger('idcoche')->unsigned();
            $table->foreign('idcategoria')->references('id')->on('categoria');
            $table->foreign('idcoche')->references('id')->on('coche');
            
            $table->timestamps();
            
            // Establecemos con esta migración que los dos campos sean unicos
            //$table->unique(['idcoche','idcategoria']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tipocategorias');
    }
}
