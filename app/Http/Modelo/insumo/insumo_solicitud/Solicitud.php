<?php

namespace siga\Modelo\insumo\insumo_solicitud;

use Illuminate\Database\Eloquent\Model;
use Auth;
use siga\Modelo\admin\Usuario;

class Solicitud extends Model
{
    protected $table = 'insumo.solicitud';

    protected $fillable = [
        'sol_id',
        'sol_id_rec',
        'sol_id_merc',
        'sol_data',
        'sol_usr_id',
        'sol_id_tipo',
        'sol_registrado',
        'sol_modificado',
        'sol_estado',
        'sol_id_planta',
        'sol_gestion',
        'sol_codnum',
        'sol_obs',
        'sol_um',
        'sol_id_origen',
        'sol_id_destino',
        'sol_cantidad',
        'sol_id_insmaq',
        'sol_nro_salida',
        'sol_aprsol_id'
    ];

    protected $primaryKey = 'sol_id';

    public $timestamps = false;

    protected static function getlistar()
    {
        $solrec = Solicitud::join('insumo.receta as rec','insumo.solicitud.sol_id_rec','=','rec.rec_id')
                    ->leftjoin('insumo.aprobacion_solicitud as aprsol','insumo.solicitud.sol_id','=','aprsol.aprsol_solicitud')
                    ->where('sol_usr_id','=',Auth::user()->usr_id)->where('sol_id_tipo','=',1)
            ->get();
        // dd($solrec);
        return $solrec;
    }
    protected static function getlistarAdiInsumo()
    {
        $solrec = Solicitud::join('insumo.receta as rec','insumo.solicitud.sol_id_rec','=','rec.rec_id')
                    ->leftjoin('insumo.aprobacion_solicitud as aprsol','insumo.solicitud.sol_id','=','aprsol.aprsol_solicitud')
                    ->where('sol_usr_id','=',Auth::user()->usr_id)->where('sol_id_tipo','=',2)
            ->get();
        return $solrec;
    }
    protected static function getlistarTraspaso()
    {
        $solrec = Solicitud::join('public._bp_planta as planta','insumo.solicitud.sol_id_origen','=','planta.id_planta')
        			->join('public._bp_planta as plant','insumo.solicitud.sol_id_destino','=','plant.id_planta')
        			->join('insumo.insumo as ins','insumo.solicitud.sol_id_insmaq','=','ins.ins_id')
        			->join('public._bp_usuarios as usu','insumo.solicitud.sol_usr_id','=','usu.usr_id')
        			->join('public._bp_personas as persona','usu.usr_prs_id','=','persona.prs_id')
                    ->leftjoin('insumo.aprobacion_solicitud as aprsol','insumo.solicitud.sol_id','=','aprsol.aprsol_solicitud')
        			->select('insumo.solicitud.sol_id','insumo.solicitud.sol_estado','insumo.solicitud.sol_registrado','planta.nombre_planta as planta_origen','plant.nombre_planta as planta_destino','persona.prs_nombres','persona.prs_paterno','persona.prs_materno','insumo.solicitud.sol_codnum','aprsol.aprsol_estado')
        			->where('sol_usr_id','=',Auth::user()->usr_id)->where('sol_id_tipo','=',3)
            ->get();
        return $solrec;
    }
    protected static function getlistarPlanta()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $solrec = Solicitud::join('insumo.receta as rec','insumo.solicitud.sol_id_rec','=','rec.rec_id')
                    ->join('public._bp_usuarios as usu','insumo.solicitud.sol_usr_id','=','usu.usr_id')
                    ->join('public._bp_personas as persona','usu.usr_prs_id','=','persona.prs_id')
                    ->leftjoin('insumo.aprobacion_solicitud as aprsol','insumo.solicitud.sol_id','=','aprsol.aprsol_solicitud')
                    ->where('sol_id_planta','=',$planta->id_planta)->where('sol_id_tipo','=',1)
            ->orderby('sol_id','DESC')->get();
        return $solrec;
    }
    protected static function getlistarAdiInsumoPlanta()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $solrec = Solicitud::join('insumo.receta as rec','insumo.solicitud.sol_id_rec','=','rec.rec_id')
                    ->join('public._bp_usuarios as usu','insumo.solicitud.sol_usr_id','=','usu.usr_id')
                    ->join('public._bp_personas as persona','usu.usr_prs_id','=','persona.prs_id')
                    ->leftjoin('insumo.aprobacion_solicitud as aprsol','insumo.solicitud.sol_id','=','aprsol.aprsol_solicitud')
                    ->where('sol_id_planta','=',$planta->id_planta)->where('sol_id_tipo','=',2)
            ->get();
        return $solrec;
    }
    protected static function getlistarTraspasoPlanta()
    {
         $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $solrec = Solicitud::join('public._bp_planta as planta','insumo.solicitud.sol_id_origen','=','planta.id_planta')
                    ->join('public._bp_planta as plant','insumo.solicitud.sol_id_destino','=','plant.id_planta')
                    ->join('insumo.insumo as ins','insumo.solicitud.sol_id_insmaq','=','ins.ins_id')
                    ->join('public._bp_usuarios as usu','insumo.solicitud.sol_usr_id','=','usu.usr_id')
                    ->join('public._bp_personas as persona','usu.usr_prs_id','=','persona.prs_id')
                    ->leftjoin('insumo.aprobacion_solicitud as aprsol','insumo.solicitud.sol_id','=','aprsol.aprsol_solicitud')
                    ->select('insumo.solicitud.sol_id','insumo.solicitud.sol_estado','insumo.solicitud.sol_registrado','planta.nombre_planta as planta_origen','plant.nombre_planta as planta_destino','persona.prs_nombres','persona.prs_paterno','persona.prs_materno','insumo.solicitud.sol_codnum','aprsol.aprsol_estado','aprsol_id')
                    ->where('sol_id_planta','=',$planta->id_planta)->where('sol_id_tipo','=',3)
            ->get();
        return $solrec;
    }
}
