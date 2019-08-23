<?php

namespace siga\Modelo\acopio\acopio_lacteos;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;
use Auth;

class ModRecepcion extends Model
{
    protected $table = 'acopio.recepcion_modulo';

    protected $fillable = [
        'recmod_id',
        'recmod_id_mod',
        'recmod_acepta',
        'recmod_cantidad',
        'recmod_cant_recep',
        'recmod_obs',
        'recmod_id_usr',
        'recmod_fecha',
        'recmod_cant_bal_recep',
        'recmod_estado_recep',
        'recmod_id_planta',
        'recmod_id_turno',
        'recmod_hora',
    ];
    protected $primaryKey = 'recmod_id';

    public $timestamps = false;

    protected static function getListarMod($id)
    {
        $usr = Auth::user()->usr_id;
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)
                            ->first();  
        $plant=$planta['id_planta'];
        $recmod_id = $id;
        $mod = ModRecepcion::where('recmod_id_mod',$id)
                            ->where('recmod_id_planta',$plant)
                            // ->where('recmod_id_usr', $usr)
                            ->get();  
        return $mod;
    }
    protected static function getListarModPlanta($id)
    {
        $usr = Auth::user()->usr_id;
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)
                            ->first();  
        $plant=$planta['id_planta'];
        $recmod_id = $id;
        $mod = ModRecepcion::where('recmod_id_mod',$id)
                            ->where('recmod_id_planta',$plant)
                            // ->where('recmod_id_usr', $usr)
                            ->get();  
        return $mod;
    }
}
