<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockProductoTerminadoHistorialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_terminado.stock_producto_terminado_historial', function (Blueprint $table) {
            $table->bigIncrements('spth_id');
            $table->integer('spth_orprod_id');
            $table->integer('spth_planta_id');
            $table->timestamp('spth_fecha');
            $table->decimal('spth_cantidad',18,2);
            $table->decimal('spth_costo',18,2);
            $table->decimal('spth_costo_unitario',18,2);
            $table->integer('spth_usr_id');
            $table->char('spth_estado',1)->default('A');
            $table->timestamp('spth_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('spth_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('spth_estado_baja',1)->default('A');
            $table->integer('spth_rece_id')->nullable();
            $table->timestampTz('spth_fecha_vencimiento')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_terminado.stock_producto_terminado_historial');
    }
}
