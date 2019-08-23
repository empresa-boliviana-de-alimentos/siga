<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMunicipioTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.municipio', function (Blueprint $table) {
            $table->bigIncrements('muni_id');
            $table->string('muni_nombre');
            $table->integer('muni_usr_id');
            $table->timestamp('muni_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('muni_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('muni_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.municipio');
    }
}
