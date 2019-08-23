<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLineaProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.linea_produccion', function (Blueprint $table) {
            $table->bigIncrements('linea_prod_id');
            $table->string('linea_prod_nombre');
            $table->integer('linea_prod_usr_id');
            $table->timestamp('linea_prod_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('linea_prod_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('linea_prod_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.linea_produccion');
    }
}
