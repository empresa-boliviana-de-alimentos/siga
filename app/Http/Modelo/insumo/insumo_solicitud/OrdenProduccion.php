<?php

namespace siga\Modelo\insumo\insumo_solicitud;

use Illuminate\Database\Eloquent\Model;

class OrdenProduccion extends Model {
	protected $table = 'insumo.orden_produccion';

	protected $fillable = [
		'orprod_id',
		'orprod_rece_id',
		'orprod_codigo',
		'orprod_nro_orden',
		'orprod_nro_solicitud',
		'orprod_nro_salida',
		'orprod_cantidad',
		'orprod_mercado_id',
		'orprod_usr_id',
		'orprod_usr_vo',
		'orprod_usr_vodos',
		'orprod_usr_aprob',
		'orprod_planta_id',
		'orprod_planta_maquila',
		'orprod_planta_traspaso',
		'orprod_tiporprod_id',
		'orprod_obs_usr',
		'orprod_obs_vo',
		'orprod_obs_vodos',
		'orprod_obs_aprob',
		'orprod_registrado',
		'orprod_modificado',
		'orprod_estado_orp',
		'orprod_estado',
		'orprod_tiempo_prod',
		'orprod_cant_esp',
		'orprod_fecha_vo',
		'orprod_fecha_vodos',
		'orprod_estado_recep',
		'orprod_estado_pt',
	];

	protected $primaryKey = 'orprod_id';

	public $timestamps = false;
}
