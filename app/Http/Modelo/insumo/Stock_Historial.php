<?php

namespace siga\Modelo\insumo;

use Illuminate\Database\Eloquent\Model;

class Stock_Historial extends Model
{
    protected $table = 'insumo.stock_historial';

    protected $fillable = [
        'his_stock_id',
        'his_stock_ins_id',
        'his_stock_planta_id',
        'his_stock_cant',
        'his_stock_cant_ingreso',
        'his_stock_cant_salida',
        'his_stock_usr_id',
        'his_stock_registrado',
        'his_stock_estado',
    ];

    protected $primaryKey = 'his_stock_id';

    public $timestamps = false;

}
