<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoEnvaseTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.tipo_envase', function (Blueprint $table) {
            $table->bigIncrements('tenv_id');
            $table->string('tenv_nombre');
            $table->integer('tenv_usr_id');
            $table->timestamp('tenv_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('tenv_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('tenv_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.tipo_envase');
    }
}
