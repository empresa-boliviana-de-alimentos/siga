<?php

namespace siga\Http\Modelo\ProductoTerminado;

use Illuminate\Database\Eloquent\Model;

class IngresoORP extends Model {
	protected $table = 'producto_terminado.ingreso_almacen_orp';
	protected $fillable = ['ipt_id', 'ipt_orprod_id', 'ipt_cantidad', 'ipt_lote', 'ipt_hora_falta', 'ipt_fecha_vencimiento', 'ipt_costo_unitario', 'ipt_registrado', 'ipt_modificado', 'ipt_usr_id', 'ipt_estado', 'ipt_observacion', 'ipt_estado_baja', 'ipt_sobrante'];
	public $timestamps = false;
	protected $primaryKey = 'ipt_id';
}
