<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('insumo.proveedor', function (Blueprint $table) {
            $table->bigIncrements('prov_id');
            $table->string('prov_nom');
            $table->string('prov_dir');
            $table->string('prov_tel');
            $table->string('prov_nom_res')->nullable();
            $table->string('prov_ap_res')->nullable();
            $table->string('prov_am_res')->nullable();
            $table->string('prov_tel_res')->nullable();
            $table->string('prov_obs')->nullable();
            $table->integer('prov_usr_id');
            $table->timestamp('prov_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('prov_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('prov_id_planta');
            $table->char('prov_estado')->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('insumo.proveedor');
    }
}
