<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;

use Auth;


class Ufv extends Model
{
    protected $table = 'insumo.ufv';

    protected $fillable = [
        'ufv_id',
        'ufv_cant',
        'ufv_usr_id',
        'ufv_registrado',
        'ufv_modificado',
        'ufv_estado',
        'ufv_id_planta'
    ];
    protected $primaryKey = 'ufv_id';

    public $timestamps = false;

    protected static function getListar()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $id=$planta->id_planta;
        $user=Auth::user()->usr_id;
        $ufv = Ufv::where('ufv_estado', 'A')
                  //->where('ufv_id_planta', $id)
                  //->where('ufv_usr_id', $user)
                  ->get();
        return $ufv;
    }

     protected static function setBuscar($id)
    {
        $ufv = Ufv::where('ufv_id', $id)->first();
        return $ufv;
    }
    protected static function getDestroy($id)
    {
        $ufv = Ufv::where('ufv_id', $id)->update(['ufv_estado' => 'B']);
        return $ufv;
    }
     protected static function getfecha()
    {
        $user=Auth::user()->usr_id;
        $ufv = Ufv::select('ufv_registrado')
                    ->where('ufv_usr_id', $user)
                    ->orderbydesc('ufv_id')
                    ->limit(1)
                    ->first();
        return $ufv;
    }
}
