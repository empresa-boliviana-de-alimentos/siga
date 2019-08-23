<?php

namespace siga\Modelo\insumo\insumo_solicitud;

use Illuminate\Database\Eloquent\Model;
use Auth;

class Solicitud_Adicional extends Model
{
    protected $table = 'insumo.solcitud_adicional';

    protected $fillable = [
        'soladi_id',
        'soladi_num_lote',
        'soladi_num_salida',
        'soladi_id_rec',
        'soladi_cantidad',
        'soladi_id_merc',
        'soladi_data',
        'soladi_obs',
        'soladi_tipo',
        'soladi_usr_id',
        'soladi_registrado',
        'soladi_modificado',
        'soladi_estado',
        'soladi_id_planta',
        'soladi_cod_nro',
        'soladi_gestion'
    ];

    protected $primaryKey = 'soladi_id';

    public $timestamps = false;

    protected static function getlistar()
    {
        $soladi = Solicitud_Adicional::where('soladi_estado','=','A')->where('soladi_usr_id','=',Auth::user()->usr_id)
            ->get();
        return $soladi;
    }
}
