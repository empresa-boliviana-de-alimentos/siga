<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoEspecificoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.producto_especifico', function (Blueprint $table) {
            $table->bigIncrements('prod_esp_id');
            $table->string('prod_esp_nombre');
            $table->integer('prod_esp_usr_id');
            $table->timestamp('prod_esp_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('prod_esp_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('prod_esp_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.producto_especifico');
    }
}
