<?php

namespace siga\Modelo\acopio;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;
use Auth;

class Envio_Almacen extends Model
{
    protected $table      = 'acopio.envio_almacen';

    protected $fillable   = [
        'enval_id',
        'enval_cant_total',
        'enval_cost_total',
        'enval_usr_id',
        'enval_registrado',
        'enval_estado',
        'enval_id_planta',
        'enval_nro_env',
        'enval_id_linea'
    ];

    public $timestamps = false;

    protected $primaryKey = 'enval_id';

    protected static function getListar()
    {
    	$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $enval = Envio_Almacen::join('public._bp_planta as pl','acopio.envio_almacen.enval_id_planta','=','pl.id_planta')
        						->where('enval_id_planta','=',$planta->id_planta)
                                ->where('enval_id_linea','=',1)
        						->where('enval_usr_id','=',Auth::user()->usr_id)
                                ->orderBy('enval_id','DESC')->get();        
        return $enval;
    }

    protected static function getListarMiel()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $envalmiel = Envio_Almacen::join('public._bp_planta as pl','acopio.envio_almacen.enval_id_planta','=','pl.id_planta')
                                ->where('enval_id_planta','=',$planta->id_planta)
                                ->where('enval_id_linea','=',3)
                                ->where('enval_usr_id','=',Auth::user()->usr_id)
                                ->get();        
        return $envalmiel;
    }

     protected static function getListarlacteos()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $envalact = Envio_Almacen::join('public._bp_planta as pl','acopio.envio_almacen.enval_id_planta','=','pl.id_planta')
                                ->where('enval_id_planta','=',$planta->id_planta)
                                ->where('enval_id_linea',2)
                                ->where('enval_usr_id','=',Auth::user()->usr_id)
                                ->orderBy('enval_id','DESC')
                                ->get();        
        return $envalact;
    }

     protected static function getfecha()
    {
        $user=Auth::user()->usr_id;
        $env = Envio_Almacen::select('enval_registrado')
                    ->where('enval_usr_id', $user)
                    ->orderbydesc('enval_id')
                    ->limit(1)
                    ->first();
        return $env;
    }
}
