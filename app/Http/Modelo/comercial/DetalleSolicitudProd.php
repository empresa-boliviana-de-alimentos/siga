<?php

namespace siga\Http\Modelo\comercial;

use Illuminate\Database\Eloquent\Model;

class DetalleSolicitudProd extends Model
{
    protected $table = 'comercial.detalle_solicitud_produccion_comercial';

    protected $fillable = [
        'detsolprod_id',
        'detsolprod_solprod_id',
        'detsolprod_prod_id',
        'detsolprod_cantidad',
        'detsolprod_tonelada',
        'detsolprod_registrado',
        'detsolprod_modificado',
        'detsolprod_estado'
    ];

    protected $primaryKey = 'detsolprod_id';

    public $timestamps = false;
}
