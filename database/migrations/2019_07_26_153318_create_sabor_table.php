<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaborTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.sabor', function (Blueprint $table) {
            $table->bigIncrements('sab_id');
            $table->string('sab_nombre');
            $table->integer('sab_usr_id');
            $table->timestamp('sab_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('sab_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('sab_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.sabor');
    }
}
