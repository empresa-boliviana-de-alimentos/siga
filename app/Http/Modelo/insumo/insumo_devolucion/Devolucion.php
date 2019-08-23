<?php

namespace siga\Modelo\insumo\insumo_devolucion;

use Illuminate\Database\Eloquent\Model;
use Auth;


class Devolucion extends Model
{
    protected $table = 'insumo.devolucion';

    protected $fillable = [
        'devo_id',
        'devo_tipodevo_id',
        'devo_nro_orden',
        'devo_nro_dev',
        'devo_nro_salida',
        'devo_planta_id',
        'devo_usr_id',
        'devo_usr_aprob',
        'devo_obs',
        'devo_obs_aprob',
        'devo_registrado',
        'devo_modificado',
        'devo_estado_dev',
        'devo_estado'
    ];

    protected $primaryKey = 'devo_id';

    public $timestamps = false;
}
