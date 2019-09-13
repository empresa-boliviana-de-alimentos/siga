<?php

namespace siga\Http\Modelo\comercial;

use Illuminate\Database\Eloquent\Model;

class IngresoPv extends Model
{
    protected $table = 'comercial.ingreso_punto_venta_comercial';

    protected $fillable = [
        'ingpv_id',
        'ingpv_origen_pv_id',
        'ingpv_nro_ingreso',
        'ingpv_obs',
        'ingpv_usr_id',
        'ingpv_pv_id',
        'ingpv_id_planta',
        'ingpv_registrado',
        'ingpv_modificado',
        'ingpv_estado',
    ];

    protected $primaryKey = 'ingpv_id';

    public $timestamps = false;
}
