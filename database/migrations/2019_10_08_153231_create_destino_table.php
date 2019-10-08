<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDestinoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_terminado.destino', function (Blueprint $table) {
            $table->bigIncrements('de_id');
            $table->text('de_nombre');
            $table->text('de_codigo')->nullable();
            $table->text('de_mercado');
            $table->integer('de_linea_trabajo')->nullable();
            $table->integer('de_planta_id')->nullable();
            $table->integer('de_departamento');
            $table->timestamp('de_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('de_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('de_usr_id');
            $table->char('de_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_terminado.destino');
    }
}
