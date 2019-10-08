<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoTerminadoHistorialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_terminado.producto_terminado_historial', function (Blueprint $table) {
            $table->bigIncrements('pth_id');
            $table->integer('pth_rece_id');
            $table->integer('pth_planta_id');
            $table->integer('pth_tipo');
            $table->integer('pth_ipt_id')->nullable();
            $table->foreign('pth_ipt_id')->references('ipt_id')->on('producto_terminado.ingreso_almacen_orp');
            $table->integer('pth_dao_id')->nullable();
            $table->foreign('pth_dao_id')->references('dao_id')->on('producto_terminado.despacho_almacen_orp');
            $table->decimal('pth_cantidad',18,2);
            $table->timestamp('pth_fecha_vencimiento');
            $table->text('pth_lote');
            $table->timestamp('pth_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('pth_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('pth_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_terminado.producto_terminado_historial');
    }
}
