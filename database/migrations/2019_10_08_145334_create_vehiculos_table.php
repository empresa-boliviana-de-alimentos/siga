<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiculosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_terminado.vehiculos', function (Blueprint $table) {
            $table->bigIncrements('veh_id');
            $table->text('veh_placa');
            $table->text('veh_marca')->nullable();
            $table->text('veh_modelo')->nullable();
            $table->text('veh_tipo');
            $table->text('veh_chasis');
            $table->text('veh_roseta_soat');
            $table->text('veh_roseta_inspeccion');
            $table->text('veh_restriccion_transito');
            $table->text('veh_restriccion_municipio');
            $table->integer('veh_usr_id');
            $table->timestamp('veh_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('veh_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('veh_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_terminado.vehiculos');
    }
}
