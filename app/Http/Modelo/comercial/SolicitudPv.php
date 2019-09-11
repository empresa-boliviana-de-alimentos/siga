<?php

namespace siga\Http\Modelo\comercial;

use Illuminate\Database\Eloquent\Model;

class SolicitudPv extends Model
{
    protected $table = 'comercial.solicitud_pv_comercial';

    protected $fillable = [
        'solpv_id',
        'solpv_pv_id',
        'solpv_id_planta',
        'solpv_nro_solicitud',
        'solpv_usr_id',
        'solpv_obs',
        'solpv_registrado',
        'solpv_modificado',
        'solpv_estado',
        'solpv_usr_aprob',
        'solpv_obs_aprob',
        'solpv_descripestado_recep',
        'solpv_estado_recep'
    ];

    protected $primaryKey = 'solpv_id';

    public $timestamps = false;
}
