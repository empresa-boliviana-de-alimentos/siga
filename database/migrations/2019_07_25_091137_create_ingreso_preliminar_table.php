<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoPreliminarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.ingreso_preliminar', function (Blueprint $table) {
            $table->bigIncrements('ingpre_id');
            $table->integer('ingpre_id_tiping');
            $table->string('ingpre_nrofactura')->nullable();
            $table->text('ingpre_factura')->nullable();
            $table->string('ingpre_remision');
            $table->date('ingpre_fecha_remision');
            $table->string('ingpre_nrocontrato')->nullable();
            $table->bigInteger('ingpre_enumeracion');
            $table->integer('ingpre_usr_id');
            $table->integer('ingpre_planta_id');
            $table->timestamp('ingpre_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('ingpre_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('ingpre_estado')->default('A');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.ingreso_preliminar');
    }
}
