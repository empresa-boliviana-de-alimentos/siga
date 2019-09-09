<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipoPvComercialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comercial.tipo_pv_comercial', function (Blueprint $table) {
            $table->bigIncrements('tipopv_id');
            $table->string('tipopv_nombre');
            $table->text('tipopv_descripcion');
            $table->integer('tipopv_usr_id');
            $table->timestamp('tipopv_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('tipopv_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->char('tipopv_estado',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comercial.tipo_pv_comercial');
    }
}
