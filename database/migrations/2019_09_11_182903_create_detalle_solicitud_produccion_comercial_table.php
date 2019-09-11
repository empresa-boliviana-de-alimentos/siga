<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleSolicitudProduccionComercialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comercial.detalle_solicitud_produccion_comercial', function (Blueprint $table) {
            $table->bigIncrements('detsolprod_id');
            $table->integer('detsolprod_solprod_id');
            $table->foreign('detsolprod_solprod_id')->references('solprod_id')->on('comercial.solicitud_produccion_comercial');
            $table->integer('detsolprod_prod_id');
            $table->foreign('detsolprod_prod_id')->references('prod_id')->on('comercial.producto_comercial');
            $table->decimal('detsolprod_cantidad',18,2);
            $table->decimal('detsolprod_tonelada',18,2);
            $table->timestamp('detsolprod_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('detsolprod_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('detsolprod_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comercial.detalle_solicitud_produccion_comercial');
    }
}
