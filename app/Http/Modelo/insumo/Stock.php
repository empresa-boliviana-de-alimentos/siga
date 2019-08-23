<?php

namespace siga\Modelo\insumo;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'insumo.stock';

    protected $fillable = [
        'stock_id',
        'stock_ins_id',
        'stock_deting_id',
        'stock_cantidad',
        'stock_costo',
        'stock_fecha_venc',
        'stock_planta_id',
        'stock_registrado',
        'stock_modificado',
        'stock_estado'
    ];

    protected $primaryKey = 'stock_id';

    public $timestamps = false;
}
