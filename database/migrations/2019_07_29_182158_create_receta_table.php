<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecetaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.receta', function (Blueprint $table) {
            $table->bigIncrements('rece_id');
            $table->string('rece_codigo');
            $table->integer('rece_enumeracion');
            $table->text('rece_nombre');
            $table->integer('rece_lineaprod_id');
            $table->integer('rece_sublinea_id');
            //$table->foreign('rece_sublinea_id')->references('sublinea_id')->on('insumo.sublinea');
            $table->integer('rece_sabor_id');
            $table->foreign('rece_sabor_id')->references('sab_id')->on('insumo.sabor');
            $table->string('rece_presentacion');
            $table->integer('rece_uni_id');
            $table->foreign('rece_uni_id')->references('umed_id')->on('insumo.unidad_medida');
            $table->decimal('rece_prod_total',18,2);
            $table->decimal('rece_rendimiento_base',18,2);
            $table->json('rece_datos_json');
            $table->integer('rece_usr_id');
            $table->integer('rece_umed_repre')->nullable();
            $table->foreign('rece_umed_repre')->references('umed_id')->on('insumo.unidad_medida');
            $table->text('rece_obs')->nullable();
            $table->timestamp('rece_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('rece_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('rece_estado')->default('A');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.receta');
    }
}
