<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoAlmacenOrpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_terminado.ingreso_almacen_orp', function (Blueprint $table) {
            $table->bigIncrements('ipt_id');
            $table->integer('ipt_orprod_id');
            $table->decimal('ipt_cantidad',18,2);
            $table->text('ipt_lote');
            $table->text('ipt_hora_falta');
            $table->date('ipt_fecha_vencimiento');
            $table->decimal('ipt_costo_unitario',10,2);
            $table->text('ipt_observacion')->nullable();
            $table->integer('ipt_sobrante')->nullable();
            $table->timestamp('ipt_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('ipt_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));   
            $table->integer('ipt_usr_id');
            $table->char('ipt_estado',1)->default('A');
            $table->char('ipt_estado_baja',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_terminado.ingreso_almacen_orp');
    }
}
