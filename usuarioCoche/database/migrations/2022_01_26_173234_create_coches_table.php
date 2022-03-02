<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCochesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coche', function (Blueprint $table) {
            $table->id();
            
            //marca, modelo, color, precio
            $table->string('marca', 50);
            $table->string('modelo', 70);
            $table->string('color', 30);
            $table->decimal('precio', 10, 2);
            
            
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
        Schema::dropIfExists('coches');
    }
}
