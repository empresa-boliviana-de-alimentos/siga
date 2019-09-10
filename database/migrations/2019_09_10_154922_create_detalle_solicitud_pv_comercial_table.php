<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleSolicitudPvComercialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comercial.detalle_solicitud_pv_comercial', function (Blueprint $table) {
            $table->bigIncrements('detsolpv_id');
            $table->integer('detsolpv_solpv_id');
            $table->foreign('detsolpv_solpv_id')->references('solpv_id')->on('comercial.solicitud_pv_comercial');
            $table->integer('detsolpv_prod_id');
            $table->foreign('detsolpv_prod_id')->references('prod_id')->on('comercial.producto_comercial');
            $table->decimal('detsolpv_cantidad',18,2);
            $table->timestamp('detsolpv_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('detsolpv_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('detsolpv_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comercial.detalle_solicitud_pv_comercial');
    }
}
