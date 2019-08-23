<?php

namespace siga\Modelo\insumo;

use Illuminate\Database\Eloquent\Model;

class InsumoHistorial extends Model
{
     protected $table = 'insumo.insumo_historial';

    protected $fillable = [
        'inshis_id',
        'inshis_ins_id',
        'inshis_planta_id',
        'inshis_tipo',
        'inshis_deting_id',
        'inshis_detorprod_id',
        'inshis_cantidad',
        'inshis_registrado',
        'inshis_modificado',
        'inshis_estado'
    ];

    protected $primaryKey = 'inshis_id';

    public $timestamps = false;
}
