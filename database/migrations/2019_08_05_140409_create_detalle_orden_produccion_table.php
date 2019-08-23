<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleOrdenProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.detalle_orden_produccion', function (Blueprint $table) {
            $table->bigIncrements('detorprod_id');
            $table->bigInteger('detorprod_orprod_id');
            $table->foreign('detorprod_orprod_id')->references('orprod_id')->on('insumo.orden_produccion');
            $table->bigInteger('detorprod_ins_id');
            $table->foreign('detorprod_ins_id')->references('ins_id')->on('insumo.insumo');
            $table->decimal('detorprod_cantidad',18,2);
            $table->timestamp('detorprod_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('detorprod_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('detorprod_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.detalle_orden_produccion');
    }
}
