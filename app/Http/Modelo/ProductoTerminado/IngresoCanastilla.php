<?php

namespace siga\Http\Modelo\ProductoTerminado;

use Illuminate\Database\Eloquent\Model;

class IngresoCanastilla extends Model {
	protected $table = 'producto_terminado.ingreso_almacen_canastillo';
	protected $fillable = ['iac_id', 'iac_ctl_id', 'iac_nro_ingreso', 'iac_fecha_ingreso', 'iac_cantidad', 'iac_origen', 'iac_observacion', 'iac_registrado', 'iac_modificado', 'iac_usr_id', 'iac_estado', 'iac_chofer', 'iac_de_id', 'iac_fecha_salida', 'iac_codigo_salida', 'iac_estado_baja'];
	public $timestamps = false;
	protected $primaryKey = 'iac_id';
}