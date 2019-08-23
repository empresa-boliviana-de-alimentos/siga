<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.stock', function (Blueprint $table) {
            $table->bigIncrements('stock_id');
            $table->integer('stock_ins_id');
            $table->foreign('stock_ins_id')->references('ins_id')->on('insumo.insumo');
            $table->integer('stock_deting_id');
            $table->foreign('stock_deting_id')->references('deting_id')->on('insumo.detalle_ingreso');
            $table->decimal('stock_cantidad');
            $table->decimal('stock_costo');
            $table->date('stock_fecha_venc');
            $table->integer('stock_planta_id');
            $table->timestamp('stock_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('stock_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('stock_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.stock');
    }
}
