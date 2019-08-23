<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUnidadMedidaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.unidad_medida', function (Blueprint $table) {
            $table->bigIncrements('umed_id');
            $table->string('umed_nombre');
            $table->string('umed_sigla');
            $table->integer('umed_usr_id');
            $table->timestamp('umed_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('umed_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('umed_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.unidad_medida');
    }
}
