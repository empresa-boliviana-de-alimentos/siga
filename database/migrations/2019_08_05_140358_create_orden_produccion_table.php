<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdenProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.orden_produccion', function (Blueprint $table) {
            $table->bigIncrements('orprod_id');
            $table->bigInteger('orprod_rece_id');
            $table->foreign('orprod_rece_id')->references('rece_id')->on('insumo.receta');
            $table->string('orprod_codigo')->nullable();
            $table->bigInteger('orprod_nro_orden')->nullable();
            $table->bigInteger('orprod_nro_solicitud')->nullable();
            $table->bigInteger('orprod_nro_salida')->nullable();
            $table->decimal('orprod_cantidad',18,2);
            $table->integer('orprod_mercado_id');
            $table->foreign('orprod_mercado_id')->references('mer_id')->on('insumo.mercado');
            $table->integer('orprod_usr_id');
            $table->integer('orprod_usr_vo')->nullable();
            $table->integer('orprod_usr_vodos')->nullable();
            $table->integer('orprod_usr_aprob')->nullable();
            $table->integer('orprod_planta_id');
            $table->integer('orprod_planta_maquila')->nullable();
            $table->integer('orprod_planta_traspaso')->nullable();
            $table->integer('orprod_tiporprod_id');
            $table->foreign('orprod_tiporprod_id')->references('tiporprod_id')->on('insumo.tipo_orden_produccion');
            $table->text('orprod_obs_usr')->nullable();
            $table->text('orprod_obs_vo')->nullable();
            $table->text('orprod_obs_vodos')->nullable();
            $table->text('orprod_obs_aprob')->nullable();
            $table->string('orprod_tiempo_prod')->nullable();
            $table->timestamp('orprod_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('orprod_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('orprod_estado_orp',1)->default('A');
            $table->char('orprod_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.orden_produccion');
    }
}
