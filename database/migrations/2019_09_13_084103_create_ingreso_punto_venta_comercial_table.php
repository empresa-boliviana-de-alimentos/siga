<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoPuntoVentaComercialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comercial.ingreso_punto_venta_comercial', function (Blueprint $table) {
            $table->bigIncrements('ingpv_id');
            $table->integer('ingpv_origen_pv_id');
            $table->foreign('ingpv_origen_pv_id')->references('pv_id')->on('comercial.punto_venta_comercial');
            $table->bigInteger('ingpv_nro_ingreso');
            $table->text('ingpv_obs');
            $table->integer('ingpv_usr_id');
            $table->integer('ingpv_pv_id');
            $table->foreign('ingpv_pv_id')->references('pv_id')->on('comercial.punto_venta_comercial');
            $table->integer('ingpv_id_planta');
            $table->timestamp('ingpv_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('ingpv_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('ingpv_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comercial.ingreso_punto_venta_comercial');
    }
}
