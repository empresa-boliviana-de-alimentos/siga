<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.categoria', function (Blueprint $table) {
            $table->bigIncrements('cat_id');
            $table->string('cat_nombre');
          //  $table->integer('cat_id_partida');
          //  $table->foreign('cat_id_partida')->references('part_id')->on('insumo.partida');
            $table->integer('cat_usr_id');
            $table->timestamp('cat_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('cat_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('cat_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.categoria');
    }
}
