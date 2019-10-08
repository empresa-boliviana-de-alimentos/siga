<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIngresoAlmacenCanastilloTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('producto_terminado.ingreso_almacen_canastillo', function (Blueprint $table) {
            $table->bigIncrements('iac_id');
            $table->integer('iac_ctl_id');
            $table->text('iac_nro_ingreso')->nullable();
            $table->date('iac_fecha_ingreso');
            $table->integer('iac_cantidad');
            $table->integer('iac_origen'); 
            $table->text('iac_observacion')->nullable();
            $table->integer('iac_chofer');   
            $table->integer('iac_de_id')->nullable();    
            $table->timestamp('iac_fecha_salida')->nullable();
            $table->text('iac_codigo_salida')->nullable();
            $table->char('iac_estado',1)->default('A');
            $table->timestamp('iac_registrado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('iac_modificado')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->integer('iac_usr_id');
            $table->char('iac_estado_baja',1)->default('A');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('producto_terminado.ingreso_almacen_canastillo');
    }
}
