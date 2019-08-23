<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevolucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.devolucion', function (Blueprint $table) {
            $table->bigIncrements('devo_id');
            $table->bigInteger('devo_tipodevo_id');            
            $table->foreign('devo_tipodevo_id')->references('tipodevo_id')->on('insumo.tipo_devolucion');
            $table->bigInteger('devo_nro_orden');
            $table->bigInteger('devo_nro_dev')->nullable();
            $table->bigInteger('devo_nro_salida')->nullable();
            $table->integer('devo_usr_id');
            $table->integer('devo_usr_aprob')->nullable();
            $table->integer('devo_planta_id');
            $table->text('devo_obs')->nullable();
            $table->text('devo_obs_aprob')->nullable();
            $table->timestamp('devo_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('devo_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('devo_estado_dev',1)->default('A');
            $table->char('devo_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.devolucion');
    }
}
