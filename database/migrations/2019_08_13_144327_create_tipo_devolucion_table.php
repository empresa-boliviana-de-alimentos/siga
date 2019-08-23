<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoDevolucionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.tipo_devolucion', function (Blueprint $table) {
            $table->increments('tipodevo_id');
            $table->string('tipodevo_nombre');
            $table->char('tipodevo_estado',1)->default('A');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.tipo_devolucion');
    }
}
