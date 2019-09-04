<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AdiccionColumOrpTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('insumo.orden_produccion', function (Blueprint $table) {
            $table->timestamp('orprod_fecha_vo')->nullable();
            $table->timestamp('orprod_fecha_vodos')->nullable();
            $table->string('orprod_estado_recep')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('insumo.orden_produccion', function (Blueprint $table) {
            $table->dropColumn('orprod_fecha_vo')->nullable();
            $table->dropColumn('orprod_fecha_vodos')->nullable();
            $table->dropColumn('orprod_estado_recep')->nullable();
        });
    }
}
