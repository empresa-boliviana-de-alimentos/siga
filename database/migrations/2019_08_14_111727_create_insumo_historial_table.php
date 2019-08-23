<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsumoHistorialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.insumo_historial', function (Blueprint $table) {
            $table->bigIncrements('inshis_id');
            $table->bigInteger('inshis_ins_id');
            $table->foreign('inshis_ins_id')->references('ins_id')->on('insumo.insumo');
            $table->integer('inshis_planta_id');
            $table->enum('inshis_tipo', ['Entrada', 'Salida']);
            $table->bigInteger('inshis_deting_id')->nullable();
            $table->foreign('inshis_deting_id')->references('deting_id')->on('insumo.detalle_ingreso');
            $table->bigInteger('inshis_detorprod_id')->nullable();
            $table->foreign('inshis_detorprod_id')->references('detorprod_id')->on('insumo.detalle_orden_produccion');
            $table->decimal('inshis_cantidad',18,2);
            $table->timestamp('inshis_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('inshis_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('inshis_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.insumo_historial');
    }
}
