<?php

namespace siga\Modelo\acopio\acopio_lacteos;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;
use Auth;

//class Persona extends Model
class AcopioGR extends Model
{
    protected $table = 'acopio.det_acoreslac';

    protected $fillable = [
        'detlac_id',
        'detlac_id_rec',
        'detlac_fecha',
        'detlac_cant',
        'detlac_obs',
        'detlac_tem',
        'detlac_sng',
        'detlac_palc',
        'detlac_aspecto',
        'detlac_color',
        'detlac_olor',
        'detlac_sabor',
        'detlac_estado',
        'detlac_fecha_reg',
        'detlac_cant_prov',
        'detlac_est_reg',
        'detlac_nom_rec',
        'detlac_envio',
        'detlac_acept_aco',
        'detlac_id_planta',
        'detlac_id_turno',
    ];
    protected $primaryKey = 'detlac_id';

    public $timestamps = false;

    protected static function getListar()
    {
       
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $id=$planta['id_planta'];

        $listacop = \DB::table('acopio.det_acoreslac')
               ->join('public._bp_usuarios', 'acopio.det_acoreslac.detlac_id_rec', '=', 'usr_id')
               ->join('public._bp_personas', '_bp_usuarios.usr_prs_id', '=', 'public._bp_personas.prs_id')
               ->join('public._bp_planta as plan', 'public._bp_usuarios.usr_planta_id', '=','plan.id_planta')
              // ->where('detlac_id_rec', $usr)
               ->where('detlac_id_planta',$id)
               ->get();
        return $listacop;
    }
  
     protected static function setBuscar($id)
    {
        $proveedor=\DB::table('acopio.det_acoreslac')
               ->join('public._bp_usuarios', 'acopio.det_acoreslac.detlac_id_rec', '=', 'usr_id')
               ->join('public._bp_personas', '_bp_usuarios.usr_prs_id', '=', 'public._bp_personas.prs_id')
               ->where('detlac_id',$id)
               ->first();
        return $proveedor;
    }

    protected static function getfecha()
    {
        $turno = Usuario::where('usr_id','=',Auth::user()->usr_id)->first();
        // dd(is_null($turno['usr_id_turno']));
        if (is_null($turno['usr_id_turno'])) {
            $user=Auth::user()->usr_usuario;
            $fech = AcopioGR::select('detlac_fecha_reg', 'detlac_id_turno')
                    ->where('detlac_nom_rec', $user)
                    ->where('detlac_id_turno',0)
                    ->orderbydesc('detlac_id')
                    ->limit(1)
                    ->first();
         return $fech;
            
        }else{
            $user=Auth::user()->usr_usuario;
            if($turno['usr_id_turno']==1){
            $fech = AcopioGR::select('detlac_fecha_reg', 'detlac_id_turno')
                        ->where('detlac_nom_rec', $user)
                        ->where('detlac_id_turno',1)
                        ->orderbydesc('detlac_id')
                        ->limit(1)
                        ->first();
             return $fech;
            }if ($turno['usr_id_turno']==2) {
            $fech = AcopioGR::select('detlac_fecha_reg', 'detlac_id_turno')
                        ->where('detlac_nom_rec', $user)
                        ->where('detlac_id_turno',2)
                        ->orderbydesc('detlac_id')
                        ->limit(1)
                        ->first();
             return $fech;
        }
       }
    }
 
}
