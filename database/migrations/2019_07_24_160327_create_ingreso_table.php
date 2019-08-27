<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.ingreso', function (Blueprint $table) {
            $table->bigIncrements('ing_id');
            $table->integer('ing_id_tiping');
            $table->foreign('ing_id_tiping')->references('ting_id')->on('insumo.tipo_ingreso');
            $table->string('ing_nrofactura')->nullable();
            $table->text('ing_factura')->nullable();
            $table->string('ing_remision')->nullable();
            $table->date('ing_fecha_remision')->nullable();
            $table->string('ing_nrocontrato')->nullable();
            $table->bigInteger('ing_enumeracion');
            $table->integer('ing_usr_id');
            $table->integer('ing_planta_id');
            $table->timestamp('ing_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('ing_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('ing_estado',1)->default('A');
            $table->bigInteger('ing_env_acop_id')->nullable();
            $table->text('ing_obs')->nullable();
            $table->integer('ing_planta_traspaso')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.ingreso');
    }
}
