<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;
use Auth;

class Devolucion_Dinero extends Model
{
    protected $table      = 'acopio.devolucion_dinero';

    protected $fillable   = [
        'devodi_id',
        'devodi_dinero',
        'devodi_usr_id',
        'devodi_registrado',
        'devodi_estado'
    ];

    public $timestamps = false;

    protected $primaryKey = 'devodi_id';

    protected static function getListar()
    {
    	$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',Auth::user()->usr_id)->first();
        $devodi = Devolucion_Dinero::where('devodi_usr_id','=',Auth::user()->usr_id)
                                ->orderBy('devodi_id','DESC')->get();        
        return $devodi;
    }
}
