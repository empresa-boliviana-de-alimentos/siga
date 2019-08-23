<?php

namespace siga\Modelo\insumo\insumo_solicitud;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Solicitud_Maquila extends Model
{
    protected $table = 'insumo.solcitud_maquila';

    protected $fillable = [
        'solmaq_id',
        'solmaq_id_ins',
        'solmaq_cantidad',
        'solmaq_vm',
        'solmaq_origen',
        'solmaq_destino',
        'solmaq_obs',
        'solmaq_usr_id',
        'solmaq_tipo',
        'solmaq_registrado',
        'solmaq_modificado',
        'solmaq_estado',
        'solmaq_id_planta',
        'solmaq_cod_nro',
        'solmaq_gestion'
    ];

    protected $primaryKey = 'solmaq_id';

    public $timestamps = false;

    protected static function getlistar()
    {
        $solrec = Solicitud_Maquila::join('public._bp_planta as planta','insumo.solcitud_maquila.solmaq_origen','=','planta.id_planta')
        			->join('public._bp_planta as plant','insumo.solcitud_maquila.solmaq_destino','=','plant.id_planta')
        			->join('insumo.insumo as ins','insumo.solcitud_maquila.solmaq_id_ins','=','ins.ins_id')
        			->join('public._bp_usuarios as usu','insumo.solcitud_maquila.solmaq_usr_id','=','usu.usr_id')
        			->join('public._bp_personas as persona','usu.usr_prs_id','=','persona.prs_id')
        			->select('insumo.solcitud_maquila.solmaq_id','insumo.solcitud_maquila.solmaq_estado','insumo.solcitud_maquila.solmaq_registrado','planta.nombre_planta as planta_origen','plant.nombre_planta as planta_destino','persona.prs_nombres','persona.prs_paterno','persona.prs_materno')
        			->where('solmaq_estado','=','A')->where('solmaq_usr_id','=',Auth::user()->usr_id)
            ->get();
        return $solrec;
    }
}
