<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockProductoTerminadoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_terminado.stock_producto_terminado', function (Blueprint $table) {
            $table->bigIncrements('spt_id');
            $table->integer('spt_orprod_id');
            $table->integer('spt_planta_id');
            $table->timestamp('spt_fecha');
            $table->decimal('spt_cantidad',18,2);
            $table->decimal('spt_costo',18,2);
            $table->decimal('spt_costo_unitario',18,2);
            $table->integer('spt_usr_id');
            $table->char('spt_estado',1)->default('A');
            $table->timestamp('spt_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('spt_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('spt_estado_baja',1)->default('A');
            $table->integer('spt_rece_id')->nullable();
            $table->timestampTz('spt_fecha_vencimiento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_terminado.stock_producto_terminado');
    }
}
