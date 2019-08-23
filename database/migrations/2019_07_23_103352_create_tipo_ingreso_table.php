<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.tipo_ingreso', function (Blueprint $table) {
            $table->bigIncrements('ting_id');
            $table->string('ting_nombre');
            $table->integer('ting_usr_id');
            $table->timestamp('ting_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('ting_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('ting_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.tipo_ingreso');
    }
}
