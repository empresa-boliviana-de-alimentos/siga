<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarritoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.carrito', function (Blueprint $table) {
            $table->bigIncrements('carr_id');
            $table->integer('carr_ins_id');
            $table->integer('carr_prov_id');
            $table->decimal('carr_cantidad');
            $table->decimal('carr_costo',18,2);
            $table->date('carr_fecha_venc');
            $table->integer('carr_usr_id');
            $table->integer('carr_planta_id');
            $table->timestamp('carr_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.carrito');
    }
}
