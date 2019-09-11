<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductoComercialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comercial.producto_comercial', function (Blueprint $table) {
            $table->bigIncrements('prod_id');
            $table->bigInteger('prod_rece_id');
            $table->string('prod_codigo')->nullable();
            $table->timestamp('prod_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('prod_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('prod_estado',1)->default('A'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comercial.producto_comercial');
    }
}
