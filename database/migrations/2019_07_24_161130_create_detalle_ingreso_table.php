<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.detalle_ingreso', function (Blueprint $table) {
            $table->bigIncrements('deting_id');
            $table->integer('deting_ing_id');
            $table->foreign('deting_ing_id')->references('ing_id')->on('insumo.ingreso');
            $table->integer('deting_ins_id');
            $table->foreign('deting_ins_id')->references('ins_id')->on('insumo.insumo');
            $table->integer('deting_prov_id');
            $table->foreign('deting_prov_id')->references('prov_id')->on('insumo.proveedor');
            $table->decimal('deting_cantidad',18,2);
            $table->decimal('deting_costo',18,2);
            $table->date('deting_fecha_venc')->nullable();
            $table->timestamp('deting_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('deting_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('deting_estado',1)->default('A');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.detalle_ingreso');
    }
}
