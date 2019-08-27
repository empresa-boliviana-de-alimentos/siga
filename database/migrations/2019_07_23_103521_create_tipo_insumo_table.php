<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoInsumoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.tipo_insumo', function (Blueprint $table) {
            $table->bigIncrements('tins_id');
            $table->string('tins_nombre');
            $table->integer('tins_usr_id');
            $table->timestamp('tins_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('tins_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('tins_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.tipo_insumo');
    }
}
