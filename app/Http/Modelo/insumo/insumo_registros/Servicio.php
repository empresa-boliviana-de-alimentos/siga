<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;

use Auth;

class Servicio extends Model
{
    protected $table = 'insumo.servicio';

    protected $fillable = [
        'serv_id',
        'serv_nom',
        'serv_emp',
        'serv_nit',
        'serv_nfact',
        'serv_costo',
        'serv_id_mes',
        'serv_usr_id',
        'serv_obs',
        'serv_fecha_pago',
        'serv_registrado',
        'serv_modificado',
        'serv_estado',
        'serv_id_planta'
    ];
    protected $primaryKey = 'serv_id';

    public $timestamps = false;

    protected static function getListar()
    {
         $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id=$planta->id_planta;

        $user=Auth::user()->usr_id;
        $servicio = Servicio::where('serv_estado', 'A')
                  //->where('serv_usr_id', $user)
                  ->where('serv_id_planta',$id)
                  ->get();
        return $servicio;
    }

     protected static function setBuscar($id)
    {
        $servicio = Servicio::where('serv_id', $id)->first();
        return $servicio;
    }
    protected static function getDestroy($id)
    {
        $servicio = Servicio::where('serv_id', $id)->update(['serv_estado' => 'B']);
        return $servicio;
    }
}
