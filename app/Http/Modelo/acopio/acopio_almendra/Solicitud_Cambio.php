<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class Solicitud_Cambio extends Model
{
    protected $table = 'acopio.solicitud_cambio';

    protected $fillable = [
    	'solcam_id',
    	'solcam_aco_id',
    	'solcam_usr_id',
    	'solcam_cantidad',
    	'solcam_costo_unitario',
    	'solcam_costo_total',
    	'solcam_peso_caja',
    	'solcam_nro_recibo',
    	'solcam_tipo_id',
    	'solcam_observacion',
    	'solcam_estado',
    	'solcam_fecha_registro'
	];
	protected $primaryKey = 'solcam_id';
	public $timestamps    = false;
}
