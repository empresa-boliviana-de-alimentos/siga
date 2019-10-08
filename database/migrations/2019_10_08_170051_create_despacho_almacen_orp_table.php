<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDespachoAlmacenOrpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_terminado.despacho_almacen_orp', function (Blueprint $table) {
            $table->bigIncrements('dao_id');
            $table->integer('dao_ipt_id');
            $table->foreign('dao_ipt_id')->references('ipt_id')->on('producto_terminado.ingreso_almacen_orp');
            $table->integer('dao_codigo')->nullable();
            $table->integer('dao_de_id');
            $table->foreign('dao_de_id')->references('de_id')->on('producto_terminado.destino');
            $table->decimal('dao_cantidad',18,2);
            $table->integer('dao_tipo_orp');
            $table->text('dao_fecha_despacho');
            $table->text('dao_codigo_salida')->nullable();
            $table->timestamp('dao_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('dao_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('dao_usr_id');
            $table->char('dao_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_terminado.despacho_almacen_orp');
    }
}
