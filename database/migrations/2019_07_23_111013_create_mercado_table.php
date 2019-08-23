<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMercadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.mercado', function (Blueprint $table) {
            $table->bigIncrements('mer_id');
            $table->string('mer_nombre');
            $table->integer('mer_usr_id');
            $table->timestamp('mer_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('mer_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('mer_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.mercado');
    }
}
