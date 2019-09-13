<?php

namespace siga\Http\Modelo\ProductoTerminado;

use Illuminate\Database\Eloquent\Model;

class Correlativo extends Model {
	protected $table = 'producto_terminado.correlativo';
	protected $fillable = ['corr_id', 'corr_codigo', 'corr_correlativo', 'corr_gestion', 'corr_usr_id', 'corr_tpd_id', 'corr_registrado', 'corr_modificado', 'corr_estado'];
	public $timestamps = false;
	protected $primaryKey = 'corr_id';
}
