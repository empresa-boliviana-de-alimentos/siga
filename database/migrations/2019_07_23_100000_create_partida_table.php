<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartidaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::create('insumo.partida', function (Blueprint $table) {
            $table->bigIncrements('part_id');
            $table->string('part_codigo');
            $table->string('part_nombre');
            $table->integer('part_usr_id');
            $table->timestamp('part_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('part_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('part_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.partida');
    }
}
