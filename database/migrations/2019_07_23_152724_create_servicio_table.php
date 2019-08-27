<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServicioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.servicio', function (Blueprint $table) {
            $table->bigIncrements('serv_id');
            $table->string('serv_nom');
            $table->string('serv_emp');
            $table->string('serv_nit');
            $table->string('serv_nfact');
            $table->decimal('serv_costo',18,2);
            $table->integer('serv_id_mes');
            $table->integer('serv_usr_id');
            $table->text('serv_obs')->nullable();
            $table->date('serv_fecha_pago');
            $table->timestamp('serv_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('serv_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('serv_id_planta');
            $table->char('serv_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.servicio');
    }
}
