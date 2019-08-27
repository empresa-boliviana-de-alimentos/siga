<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePlantaMaquilaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.planta_maquila', function (Blueprint $table) {
            $table->bigIncrements('maquila_id');
            $table->string('maquila_nombre');
            $table->integer('maquila_usr_id');
            $table->timestamp('maquila_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('maquila_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('maquila_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.planta_maquila');
    }
}
