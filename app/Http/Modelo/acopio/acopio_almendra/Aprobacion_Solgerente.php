<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class Aprobacion_Solgerente extends Model
{
    protected $table = 'acopio.aprobacion_solgerente';

    protected $fillable = [
    	'apsolgerente_id',
    	'apsolgerente_aco_id',
    	'apsolgerente_usr_id',
    	'apsolgerente_apsoljefe_id',
    	'apsolgerente_estado',
    	'apsolgerente_fecha_registro',
        'apsolgerente_msj_modal'
	];
	protected $primaryKey = 'apsolgerente_id';
	public $timestamps    = false;
}
