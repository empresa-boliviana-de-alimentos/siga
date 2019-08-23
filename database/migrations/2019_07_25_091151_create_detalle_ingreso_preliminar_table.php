<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleIngresoPreliminarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.detalle_ingreso_preliminar', function (Blueprint $table) {
            $table->bigIncrements('detingpre_id');
            $table->integer('detingpre_ingpre_id');
            $table->integer('detingpre_ins_id');
            $table->integer('detingpre_prov_id');
            $table->decimal('detingpre_cantidad',18,2);
            $table->decimal('detingpre_costo',18,2);
            $table->date('detingpre_fecha_venc');
            $table->timestamp('detingpre_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('detingpre_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('detingpre_estado')->default('A');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.detalle_ingreso_preliminar');
    }
}
