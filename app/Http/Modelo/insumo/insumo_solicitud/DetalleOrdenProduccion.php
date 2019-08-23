<?php

namespace siga\Modelo\insumo\insumo_solicitud;

use Illuminate\Database\Eloquent\Model;

class DetalleOrdenProduccion extends Model
{
    protected $table = 'insumo.detalle_orden_produccion';

    protected $fillable = [
        'detorprod_id',
        'detorprod_orprod_id',
        'detorprod_ins_id',
        'detorprod_cantidad',
        'detorprod_registrado',
        'detorprod_modificado',
        'detorprod_estado',
    ];

    protected $primaryKey = 'detorprod_id';

    public $timestamps = false;
}
