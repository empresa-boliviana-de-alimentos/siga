<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStockHistorialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.stock_historial', function (Blueprint $table) {
            $table->bigIncrements('his_stock_id');
            $table->integer('his_stock_ins_id');
            //$table->foreign('his_stock_ins_id')->references('ins_id')->on('insumo.insumo');
            $table->integer('his_stock_planta_id');
            $table->decimal('his_stock_cant',18,2);
            $table->decimal('his_stock_cant_ingreso',18,2);
            $table->decimal('his_stock_cant_salida',18,2);
            $table->integer('his_stock_usr_id');
            $table->timestamp('his_stock_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('his_stock_estado',1)->default('A');        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.stock_historial');
    }
}
