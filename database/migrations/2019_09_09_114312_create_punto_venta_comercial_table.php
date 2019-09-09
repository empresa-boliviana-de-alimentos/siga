<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePuntoVentaComercialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comercial.punto_venta_comercial', function (Blueprint $table) {
            $table->bigIncrements('pv_id');
            $table->bigInteger('pv_tipopv_id');
            $table->foreign('pv_tipopv_id')->references('tipopv_id')->on('comercial.tipo_pv_comercial');
            $table->string('pv_codigo');
            $table->string('pv_nombre');
            $table->text('pv_descripcion');
            $table->text('pv_direccion');
            $table->string('pv_telefono');
            $table->integer('pv_usr_responsable');
            $table->integer('pv_depto_id');
            $table->foreign('pv_depto_id')->references('depto_id')->on('comercial.departamento_comercial');
            $table->string('pv_actividad_economica');
            $table->date('pv_fecha_inicio')->nullable();
            $table->date('pv_fecha_fin')->nullable();
            $table->integer('pv_usr_id');
            $table->timestamp('pv_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('pv_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('pv_estado',1)->default('A');        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comercial.punto_venta_comercial');
    }
}
