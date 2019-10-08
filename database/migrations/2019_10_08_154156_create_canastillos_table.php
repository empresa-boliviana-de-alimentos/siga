<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCanastillosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_terminado.canastillos', function (Blueprint $table) {
            $table->bigIncrements('ctl_id');
            $table->text('ctl_descripcion');
            $table->text('ctl_codigo');
            $table->integer('ctl_rece_id');
            $table->double('ctl_altura')->nullable();
            $table->double('ctl_ancho')->nullable();
            $table->double('ctl_largo')->nullable();
            $table->double('ctl_peso')->nullable();
            $table->text('ctl_material')->nullable();
            $table->text('ctl_observacion')->nullable();
            $table->text('ctl_logo')->nullable();
            $table->text('ctl_almacenamiento')->nullable();
            $table->text('ctl_transporte')->nullable();
            $table->text('ctl_aplicacion')->nullable();
            $table->text('ctl_foto_canastillo')->nullable();
            $table->timestamp('ctl_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('ctl_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('ctl_usr_id');
            $table->char('ctl_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_terminado.canastillos');
    }
}
