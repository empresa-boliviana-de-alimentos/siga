<?php

namespace siga\Http\Modelo\ProductoTerminado;

use Illuminate\Database\Eloquent\Model;

class despachoProductoTerminado extends Model {
	protected $table = 'producto_terminado.despacho_almacen_orp';
	protected $fillable = ['dao_id', 'dao_ipt_id', 'dao_de_id', 'dao_cantidad', 'dao_fecha_despacho', 'dao_registrado', 'dao_modificado', 'dao_usr_id', 'dao_estado', 'dao_codigo_salida'];
	public $timestamps = false;
	protected $primaryKey = 'dao_id';
}
