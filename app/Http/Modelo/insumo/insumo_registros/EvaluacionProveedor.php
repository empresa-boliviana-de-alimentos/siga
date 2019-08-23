<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class EvaluacionProveedor extends Model
{
    protected $table = 'insumo.evaluacion_proveedor';

    protected $fillable = [
        'eval_id',
        'eval_prov_id',
        'eval_evaluacion',
        'eval_costo_apro',
        'eval_fiabilidad',
        'eval_imagen',
        'eval_calidad',
        'eval_cumplimientos_plazos',
        'eval_condiciones_pago',
        'eval_capacidad_cooperacion',
        'eval_flexibilidad',
        'eval_registrado',
        'eval_modificado',
        'eval_estado'
    ];

    protected $primaryKey = 'eval_id';

    public $timestamps = false;

    protected static function getListar($id_proveedor)
    {	
    	$evaluaciones = EvaluacionProveedor::where('eval_prov_id',$id_proveedor)->get();	
       	return $evaluaciones;
    }

}
