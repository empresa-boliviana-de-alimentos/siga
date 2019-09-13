<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleIngresoPuntoVentaComercialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comercial.detalle_ingreso_punto_venta_comercial', function (Blueprint $table) {
            $table->bigIncrements('detingpv_id');
            $table->integer('detingpv_ingpv_id');
            $table->foreign('detingpv_ingpv_id')->references('ingpv_id')->on('comercial.ingreso_punto_venta_comercial');
            $table->integer('detingpv_prod_id');
            $table->foreign('detingpv_prod_id')->references('prod_id')->on('comercial.producto_comercial');
            $table->decimal('detingpv_cantidad',18,2);
            $table->decimal('detingpv_costo',18,2);
            $table->string('detingpv_lote');
            $table->date('detingpv_fecha_venc');
            $table->timestamp('detingpv_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('detingpv_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('detingpv_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comercial.detalle_ingreso_punto_venta_comercial');
    }
}
