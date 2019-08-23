<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleDevolucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.detalle_devolucion', function (Blueprint $table) {
            $table->bigIncrements('detdevo_id');
            $table->bigInteger('detdevo_devo_id');
            $table->foreign('detdevo_devo_id')->references('devo_id')->on('insumo.devolucion');
            $table->bigInteger('detdevo_ins_id');
            $table->foreign('detdevo_ins_id')->references('ins_id')->on('insumo.insumo');
            $table->decimal('detdevo_cantidad',18,2);
            $table->timestamp('detdevo_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('detdevo_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('detdevo_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.detalle_devolucion');
    }
}
