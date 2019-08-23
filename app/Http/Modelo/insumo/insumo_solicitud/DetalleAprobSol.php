<?php

namespace siga\Modelo\insumo\insumo_solicitud;

use Illuminate\Database\Eloquent\Model;

class DetalleAprobSol extends Model
{
    protected $table = 'insumo.detalle_data_aprobsol';

    protected $fillable = [
        'detaprob_id',
        'detaprob_id_aprobsol',
        'detaprob_id_ins',
        'detaprob_id_planta',
        'detaprob_cantidad',
        'detaprob_costo',
        'detaprob_usr_id',
        'detaprob_registrado',
    ];

    protected $primaryKey = 'detaprob_id';

    public $timestamps = false;
}
