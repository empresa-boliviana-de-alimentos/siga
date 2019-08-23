<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEvaluacionProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.evaluacion_proveedor', function (Blueprint $table) {
            $table->bigIncrements('eval_id');
            $table->integer('eval_prov_id');
            $table->foreign('eval_prov_id')->references('prov_id')->on('insumo.proveedor');
            $table->text('eval_evaluacion');
            $table->integer('eval_costo_apro')->nullable();
            $table->integer('eval_fiabilidad')->nullable();
            $table->integer('eval_imagen')->nullable();
            $table->integer('eval_calidad')->nullable();
            $table->integer('eval_cumplimientos_plazos')->nullable();
            $table->integer('eval_condiciones_pago')->nullable();
            $table->integer('eval_capacidad_cooperacion')->nullable();
            $table->integer('eval_flexibilidad')->nullable();
            $table->timestamp('eval_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('eval_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('eval_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.evaluacion_proveedor');
    }
}
