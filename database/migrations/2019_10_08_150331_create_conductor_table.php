<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateConductorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_terminado.conductor', function (Blueprint $table) {
            $table->bigIncrements('pcd_id');
            $table->integer('pcd_id_estado_civil');
            $table->text('pcd_ci');
            $table->text('pcd_nro_licencia');
            $table->text('pcd_categoria');
            $table->text('pcd_nombres');
            $table->text('pcd_paterno');
            $table->text('pcd_materno');
            $table->text('pcd_direccion');
            $table->text('pcd_telefono')->default('');
            $table->text('pcd_celular')->default('');
            $table->text('pcd_correo')->default('');
            $table->char('pcd_sexo',1)->default('M')->nullable();
            $table->integer('pcd_veh_id');
            $table->foreign('pcd_veh_id')->references('veh_id')->on('producto_terminado.vehiculos');
            $table->date('pcd_fec_nacimiento');
            $table->timestamp('pcd_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('pcd_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('pcd_usr_id');
            $table->char('pcd_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_terminado.conductor');
    }
}
