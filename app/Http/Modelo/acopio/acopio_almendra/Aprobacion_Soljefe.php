<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class Aprobacion_Soljefe extends Model
{
    protected $table = 'acopio.aprobacion_soljefe';

    protected $fillable = [
    	'apsoljefe_id',
    	'apsoljefe_aco_id',
    	'apsoljefe_usr_id',
    	'apsoljefe_solcam_id',
    	'apsoljefe_observacion',
    	'apsoljefe_estado',
    	'apsoljefe_fecha_registro'
	];
	protected $primaryKey = 'apsoljefe_id';
	public $timestamps    = false;
}

