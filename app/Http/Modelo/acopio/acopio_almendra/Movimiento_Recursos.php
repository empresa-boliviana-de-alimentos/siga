<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class Movimiento_Recursos extends Model
{
    protected $table = 'acopio.movimiento_recursos';

    protected $fillable = [
        'movrec_id',
        'movrec_ingreso',
        'movrec_egreso',
        'movrec_saldo',
        'movrec_id_usr',
        'movrec_id_aco',
        'movrec_id_asignacion',
        'movrec_fecha_mov',
        'movrec_estado'
    ];
    protected $primaryKey = 'movrec_id';
    public $timestamps = false;
}
