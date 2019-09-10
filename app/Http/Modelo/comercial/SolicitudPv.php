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
        'prod_registrado',
        'prod_modificado',
        'prod_estado'
    ];

    protected $primaryKey = 'solpv_id';

    public $timestamps = false;
}
