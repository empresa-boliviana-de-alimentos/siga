<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;
use Auth;
class Solicitud extends Model
{
    protected $table = 'acopio.solicitud';

    protected $fillable = [
        'sol_id',
        'sol_detalle',
        'sol_id_usr',
        'sol_monto',
        'sol_estado',
        'sol_observacion',
        'sol_id_mun',
        'sol_centr_acopio',
        'sol_fecha_reg',
        'sol_usr_modif',
        'sol_fecha_modif'
    ];
    protected $primaryKey = 'sol_id';
    public $timestamps = false;

  protected static function getListar()
    {
        // $solicitud = Solicitud::leftjoin('acopio.asignacion_presupuesto as asig','acopio.solicitud.sol_id', '=', 'asig.asig_id_sol')
        //                    ->join('public._bp_personas as per','acopio.solicitud.sol_id_usr', '=', 'per.prs_id')
        //                    -> select('per.prs_nombres','per.prs_paterno','per.prs_materno','solicitud.sol_id', 'solicitud.sol_id_usr', 'solicitud.sol_detalle', 'solicitud.sol_monto', 'solicitud.sol_fecha_reg', 'solicitud.sol_estado', 'asig.asig_fecha_reg', 'asig.asig_monto' )
        //                       ->GROUPBY ('per.prs_nombres','per.prs_paterno','per.prs_materno','solicitud.sol_id', 'solicitud.sol_id_usr', 'solicitud.sol_detalle', 'solicitud.sol_monto', 'solicitud.sol_fecha_reg', 'solicitud.sol_estado', 'asig.asig_fecha_reg', 'asig.asig_monto')
        //                     ->get();
        $solicitud = Solicitud::leftjoin('acopio.asignacion_presupuesto as asig','acopio.solicitud.sol_id', '=', 'asig.asig_id_sol')
                           ->join('public._bp_usuarios as us','acopio.solicitud.sol_id_usr', '=', 'us.usr_id')
                           // ->join('public._bp_personas as per','public._bp_usuarios.usr_prs_id', '=', 'per.prs_id')
                           -> select('us.usr_usuario','solicitud.sol_id', 'solicitud.sol_id_usr', 'solicitud.sol_detalle', 'solicitud.sol_monto', 'solicitud.sol_fecha_reg', 'solicitud.sol_estado', 'asig.asig_fecha_reg', 'asig.asig_monto','asig.asig_estado')
                              ->GROUPBY ('us.usr_usuario','solicitud.sol_id', 'solicitud.sol_id_usr', 'solicitud.sol_detalle', 'solicitud.sol_monto', 'solicitud.sol_fecha_reg', 'solicitud.sol_estado', 'asig.asig_fecha_reg', 'asig.asig_monto','asig.asig_estado')
                            ->get();
        return $solicitud;
    }     
    protected static function getListar2()
        {  
          $ids=Auth::user()->usr_usuario;
          $solicitud = Solicitud::leftjoin('acopio.asignacion_presupuesto as asig','acopio.solicitud.sol_id', '=', 'asig.asig_id_sol')
                               ->join('public._bp_usuarios as us','acopio.solicitud.sol_id_usr', '=', 'us.usr_id')
                               // ->join('public._bp_personas as per','public._bp_usuarios.usr_prs_id', '=', 'per.prs_id')
                               -> select('us.usr_usuario','solicitud.sol_id', 'solicitud.sol_id_usr', 'solicitud.sol_detalle', 'solicitud.sol_monto', 'solicitud.sol_fecha_reg', 'solicitud.sol_estado', 'asig.asig_fecha_reg', 'asig.asig_monto','asig.asig_estado' )
                                  ->GROUPBY ('us.usr_usuario','solicitud.sol_id', 'solicitud.sol_id_usr', 'solicitud.sol_detalle', 'solicitud.sol_monto', 'solicitud.sol_fecha_reg', 'solicitud.sol_estado', 'asig.asig_fecha_reg', 'asig.asig_monto','asig.asig_estado')
                                  ->where('us.usr_usuario',$ids)
                                ->get();

                   return $solicitud;              
    }





    protected static function setBuscar($id)
    {
      // $solicitud = Solicitud::join('public._bp_personas as per','acopio.solicitud.sol_id_usr', '=', 'per.prs_id')
        //                       ->where('acopio.solicitud.sol_id', $id)->first();
        //return $solicitud;


       $solicitud = Solicitud::join('public._bp_usuarios as us','acopio.solicitud.sol_id_usr', '=', 'us.usr_id')
                               ->where('acopio.solicitud.sol_id', $id)->first();
        return $solicitud;

    }
    protected static function getSolicitud($id)
    {
        $Soli = Solicitud::where('sol_id', $id)->update(['sol_estado' => 'B']);
        return $Soli;
    }
}
