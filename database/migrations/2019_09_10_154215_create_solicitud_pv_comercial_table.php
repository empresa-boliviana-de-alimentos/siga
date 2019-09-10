<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudPvComercialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comercial.solicitud_pv_comercial', function (Blueprint $table) {
            $table->bigIncrements('solpv_id');
            $table->integer('solpv_pv_id');
            $table->foreign('solpv_pv_id')->references('pv_id')->on('comercial.punto_venta_comercial');
            $table->integer('solpv_id_planta');
            $table->bigInteger('solpv_nro_solicitud');
            $table->integer('solpv_usr_id');
            $table->timestamp('solpv_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('solpv_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('solpv_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comercial.solicitud_pv_comercial');
    }
}
