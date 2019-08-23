<?php

namespace siga\Modelo\acopio\acopio_lacteos;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;
use Auth;

class Modulo extends Model
{
    protected $table = 'acopio.modulo';

    protected $fillable = [
        'modulo_id',
        'modulo_modulo',
        'modulo_nombre',
        'modulo_paterno',
        'modulo_materno',
        'modulo_ci',
        'modulo_dir',
        'modulo_tel',
        'modulo_usr_id',
        'modulo_registrado',
        'modulo_modificado',
        'modulo_estado',
        'modulo_id_planta',
        'modulo_turno1',
        'modulo_turno2',
        'modulo_fecha1',
        'modulo_fecha2',
        'modulo_turno3',
        'modulo_fecha3',
    ];
    protected $primaryKey = 'modulo_id';

    public $timestamps = false;

 
    protected static function getListarModulo()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 
        $modulos = Modulo::where('modulo_estado','A')->where('modulo_id_planta','=',$planta->id_planta)
                 ->orderBy('modulo_id','DESC')
                 ->get();  
        return $modulos;
    }

     protected static function setBuscar($id)
    {
        $modulos=Modulo::where('modulo_id',$id)
        //->where('detlac_estado','A')
        ->first();
        return $modulos;
    }
}
