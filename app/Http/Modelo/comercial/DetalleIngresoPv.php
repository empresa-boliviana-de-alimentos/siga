<?php

namespace siga\Http\Modelo\comercial;

use Illuminate\Database\Eloquent\Model;

class DetalleIngresoPv extends Model
{
    protected $table = 'comercial.detalle_ingreso_punto_venta_comercial';

    protected $fillable = [
        'detingpv_id',
        'detingpv_ingpv_id',
        'detingpv_prod_id',
        'detingpv_cantidad',
        'detingpv_costo',
        'detingpv_lote',
        'detingpv_fecha_venc',
        'detingpv_registrado',
        'detingpv_modificado',
        'detingpv_estado',
    ];

    protected $primaryKey = 'detingpv_id';

    public $timestamps = false;
}