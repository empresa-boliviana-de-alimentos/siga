<?php

namespace siga\Http\Modelo\ProductoTerminado;

use Illuminate\Database\Eloquent\Model;

class ProductoTerminadoHistorial extends Model
{
    protected $table = 'producto_terminado.producto_terminado_historial';
	protected $fillable = [
		'pth_id', 
		'pth_rece_id',
		'pth_planta_id',
		'pth_tipo',
		'pth_ipt_id',
		'pth_dao_id',
		'pth_cantidad',
		'pth_fecha_vencimiento',
		'pth_lote',
		'pth_registrado',
		'pth_modificado',
		'pth_estado'
	];
	public $timestamps = false;
	protected $primaryKey = 'pth_id';
}
