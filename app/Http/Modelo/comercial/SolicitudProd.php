<?php

namespace siga\Http\Modelo\comercial;

use Illuminate\Database\Eloquent\Model;

class SolicitudProd extends Model
{
    protected $table = 'comercial.solicitud_produccion_comercial';

    protected $fillable = [
        'solprod_id',
        'solprod_pv_id',
        'solprod_id_planta',
        'solprod_nro_solicitud',
        'solprod_usr_id',
        'solprod_obs',
        'solprod_registrado',
        'solprod_modificado',
        'solprod_estado',
        'solprod_usr_aprob',
        'solprod_obs_aprob',
        'solprod_lineaprod_id',
        'solprod_descripestado_recep',
        'solprod_estado_recep',
        'solprod_fecha_posent'
    ];

    protected $primaryKey = 'solprod_id';

    public $timestamps = false;
}
