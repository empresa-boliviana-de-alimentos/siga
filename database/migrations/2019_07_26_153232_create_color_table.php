<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.color', function (Blueprint $table) {
            $table->bigIncrements('col_id');
            $table->string('col_nombre');
            $table->integer('col_usr_id');
            $table->timestamp('col_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('col_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('col_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.color');
    }
}
