<?php

namespace siga\Http\Modelo\ProductoTerminado;

use Illuminate\Database\Eloquent\Model;

class stock_pt extends Model {
	protected $table = 'producto_terminado.stock_producto_terminado';
	protected $fillable = ['spt_id', 'spt_orprod_id', 'spt_planta_id', 'spt_fecha', 'spt_cantidad', 'spt_costo', 'spt_costo_unitario', 'spt_usr_id', 'spt_estado', 'spt_registrado', 'spt_modificado', 'spt_estado_baja', 'spt_rece_id', 'spt_fecha_vencimiento'];
	public $timestamps = false;
	protected $primaryKey = 'spt_id';
}
