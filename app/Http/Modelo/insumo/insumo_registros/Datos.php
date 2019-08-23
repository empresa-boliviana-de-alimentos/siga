<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;
use Auth;

class Datos extends Model
{
    protected $table = 'insumo.dato';

    protected $fillable = [
        'dat_id',
        'dat_id_clas',
        'dat_nom',
        'dat_sigla',
        'dat_id_partida',
        'dat_usr_id',
        'dat_registrado',
        'dat_modificado',
        'dat_estado',
        'dat_id_planta'
    ];
    protected $primaryKey = 'dat_id';

    public $timestamps = false;

    protected static function getListar()
    {
       // $user=Auth::user()->usr_id;
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id=$planta->id_planta;
        $dato = Datos::leftjoin('insumo.partida as par','insumo.dato.dat_id_partida', '=', 'par.part_id')
        		   ->where('dat_estado', 'A')
                   //->where('dat_usr_id', $user)
                   ->where('dat_id_planta',$id)
                   ->get();
        return $dato;
    }

    protected static function comboIns()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id=$planta->id_planta;
       $tipinsumo = Datos::select('dat_id', 'dat_nom')
                            ->where('dat_id_clas',5)
                            ->where('dat_id_planta',$id)
                            ->get();
        return $tipinsumo;
    }

    protected static function comboCat()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id=$planta->id_planta;
       $categoria = Datos::select('dat_id', 'dat_nom')
                            ->where('dat_id_clas',1)
                            ->where('dat_id_planta',$id)
                            ->get();
        return $categoria;
    }

    protected static function comboUni()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id=$planta->id_planta;
       $unidad = Datos::select('dat_id', 'dat_nom')
                            ->where('dat_id_clas',2)
                            ->where('dat_id_planta',$id)
                            ->get();
        return $unidad;
    }   

    protected static function comboIngreso()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id=$planta->id_planta;
       $unidad = Datos::select('dat_id', 'dat_nom')
                            ->where('dat_id_clas',4)
                            ->where('dat_id_planta',$id)
                            ->get();
        return $unidad;
    }

    protected static function comboEnv()
    {
        $envase = Datos::select('dat_id','dat_nom')
                        ->where('dat_id_clas',6)
                        ->get();
        return $envase;
    }
}
