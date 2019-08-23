<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUfvTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.ufv', function (Blueprint $table) {
            $table->bigIncrements('ufv_id');
            $table->decimal('ufv_cant',8,5);
            $table->date('ufv_registrado');
            $table->integer('ufv_usr_id');
            $table->timestamp('ufv_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('ufv_id_planta');
            $table->char('ufv_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.ufv');
    }
}
