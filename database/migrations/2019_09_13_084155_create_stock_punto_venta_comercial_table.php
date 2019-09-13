<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockPuntoVentaComercialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comercial.stock_punto_venta_comercial', function (Blueprint $table) {
            $table->bigIncrements('stockpv_id');            
            $table->integer('stockpv_prod_id');
            $table->foreign('stockpv_prod_id')->references('prod_id')->on('comercial.producto_comercial');
            $table->integer('stockpv_detingpv_id');
            $table->foreign('stockpv_detingpv_id')->references('detingpv_id')->on('comercial.detalle_ingreso_punto_venta_comercial');
            $table->decimal('stockpv_cantidad',18,2);
            $table->decimal('stockpv_costo',18,2);
            $table->string('stockpv_lote');
            $table->date('stockpv_fecha_venc');
            $table->integer('stockpv_pv_id');
            $table->foreign('stockpv_pv_id')->references('pv_id')->on('comercial.punto_venta_comercial');
            $table->integer('stockpv_id_planta');
            $table->timestamp('stockpv_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('stockpv_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('stockpv_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comercial.stock_punto_venta_comercial');
    }
}
