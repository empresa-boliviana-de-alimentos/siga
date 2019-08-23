<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleRecetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.detalle_receta', function (Blueprint $table) {
            $table->bigIncrements('detrece_id');
            $table->integer('detrece_rece_id');
            $table->foreign('detrece_rece_id')->references('rece_id')->on('insumo.receta');
            $table->integer('detrece_ins_id');
            $table->foreign('detrece_ins_id')->references('ins_id')->on('insumo.insumo');
            $table->decimal('detrece_cantidad',18,2);
            $table->timestamp('detrece_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('detrece_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('detrece_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.detalle_receta');
    }
}
