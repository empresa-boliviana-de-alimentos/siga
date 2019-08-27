<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubLineaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.sub_linea', function (Blueprint $table) {
            $table->bigIncrements('sublin_id');
            $table->string('sublin_nombre');
            $table->integer('sublin_prod_id');
            $table->integer('sublin_usr_id');
            $table->timestamp('sublin_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('sublin_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('sublin_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.sub_linea');
    }
}
