<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInsumoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.insumo', function (Blueprint $table) {
            $table->bigIncrements('ins_id');
            $table->string('ins_codigo');
            $table->bigInteger('ins_enumeracion');
            $table->integer('ins_id_tip_ins');
            $table->foreign('ins_id_tip_ins')->references('tins_id')->on('insumo.tipo_insumo');
            $table->integer('ins_id_tip_env')->nullable();
            $table->integer('ins_id_part');
            $table->foreign('ins_id_part')->references('part_id')->on('insumo.partida');
            //$table->integer('ins_id_cat');
            //$table->foreign('ins_id_cat')->references('cat_id')->on('insumo.categoria');
            $table->integer('ins_id_uni')->nullable();
            //$table->foreign('ins_id_uni')->references('umed_id')->on('insumo.unidad_medida');
            $table->integer('ins_id_mercado')->nullable();
            $table->integer('ins_id_sabor')->nullable();
            $table->integer('ins_id_color')->nullable();
            $table->integer('ins_id_municipio')->nullable();
            $table->integer('ins_id_linea_prod')->nullable();
            $table->integer('ins_id_prod_especi')->nullable();
            $table->string('ins_peso_presen')->nullable();
            $table->string('ins_formato')->nullable();
            $table->text('ins_desc');
            $table->integer('ins_usr_id');
            $table->integer('ins_id_planta');
            $table->timestamp('ins_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('ins_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('ins_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.insumo');
    }
}
