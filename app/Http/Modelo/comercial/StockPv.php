<?php

namespace siga\Http\Modelo\comercial;

use Illuminate\Database\Eloquent\Model;

class StockPv extends Model
{
    protected $table = 'comercial.stock_punto_venta_comercial';

    protected $fillable = [
        'stockpv_id',          
        'stockpv_prod_id',
        'stockpv_detingpv_id',
        'stockpv_cantidad',
        'stockpv_costo',
        'stockpv_lote',
        'stockpv_fecha_venc',
        'stockpv_pv_id',
        'stockpv_id_planta',
        'stockpv_registrado',
        'stockpv_modificado',
        'stockpv_estado',
    ];

    protected $primaryKey = 'stockpv_id';
    public $timestamps = false;
}
