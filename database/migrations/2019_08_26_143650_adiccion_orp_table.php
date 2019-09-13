<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdiccionOrpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insumo.orden_produccion', function (Blueprint $table) {
            $table->integer('orprod_tiempo_prod')->nullable();
            $table->decimal('orprod_cant_esp',18,2)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('insumo.orden_produccion');
        Schema::table('insumo.orden_produccion', function (Blueprint $table) {
            $table->dropColumn('orprod_tiempo_prod')->nullable();
            $table->dropColumn('orprod_cant_esp')->nullable();
        });
    }
}
