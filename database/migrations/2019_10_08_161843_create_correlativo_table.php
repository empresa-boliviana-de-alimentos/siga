<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCorrelativoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_terminado.correlativo', function (Blueprint $table) {
            $table->bigIncrements('corr_id');
            $table->text('corr_codigo');
            $table->integer('corr_correlativo')->default(0);
            $table->integer('corr_gestion');
            $table->integer('corr_usr_id');
            $table->integer('corr_tpd_id');
            $table->timestamp('corr_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('corr_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('corr_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_terminado.correlativo');
    }
}
