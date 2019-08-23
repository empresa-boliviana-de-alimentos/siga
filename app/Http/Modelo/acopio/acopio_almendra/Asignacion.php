<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    protected $table = 'acopio.asignacion_presupuesto';

    protected $fillable = [
        'asig_id',
        'asig_id_comp',
        'asig_monto',
        'asig_fecha',
        'asig_obs',
        'asig_id_usr',
        'asig_estado',
        'asig_fecha_reg',
        'asig_id_sol'
    ];
    protected $primaryKey = 'asig_id';
    public $timestamps = false;
}
