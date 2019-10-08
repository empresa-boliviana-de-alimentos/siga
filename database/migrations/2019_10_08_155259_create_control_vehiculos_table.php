<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateControlVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_terminado.control_vehiculos', function (Blueprint $table) {
            $table->bigIncrements('ctrv_id');
            $table->integer('ctrv_id_vehiculo')->nullable();
            $table->foreign('ctrv_id_vehiculo')->references('veh_id')->on('producto_terminado.vehiculos');
            $table->jsonb('ctrv_check_equipos')->default('{"gata_est": "0", "llanta_est": "0", "llaves_est": "0", "botiquin_est": "0", "extintor_est": "0", "promedio_est1": "0", "atomizador_est": "0", "montacarga_est": "0", "termometro_est": "0", "herramientas_est": "0", "observaciones_est1": "0"}');
            $table->jsonb('ctrv_check_limpieza')->default('{"furgon_est": "0", "pintado_est": "0", "promedio_est2": "0", "implemento_est": "0", "limpieza_ext_est": "0", "limpieza_int_est": "0", "observaciones_est2": "0"}');
            $table->jsonb('ctrv_check_mecanicas')->default('{}');
            $table->timestamp('ctrv_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('ctrv_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('ctrv_usr_id');
            $table->char('ctrv_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_terminado.control_vehiculos');
    }
}
