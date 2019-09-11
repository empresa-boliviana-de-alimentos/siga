<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudProduccionComercialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comercial.solicitud_produccion_comercial', function (Blueprint $table) {
            $table->bigIncrements('solprod_id');
            $table->integer('solprod_pv_id');
            $table->foreign('solprod_pv_id')->references('pv_id')->on('comercial.punto_venta_comercial');
            $table->integer('solprod_id_planta');
            $table->bigInteger('solprod_nro_solicitud');
            $table->integer('solprod_usr_id');
            $table->text('solprod_obs')->nullable();
            $table->integer('solprod_usr_aprob')->nullable();
            $table->text('solprod_obs_aprob')->nullable();
            $table->integer('solprod_lineaprod_id');
            $table->date('solprod_fecha_posent');
            $table->timestamp('solprod_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('solprod_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('solprod_descripestado_recep')->nullable();
            $table->char('solprod_estado_recep',1)->default('A');
            $table->char('solprod_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comercial.solicitud_produccion_comercial');
    }
}
