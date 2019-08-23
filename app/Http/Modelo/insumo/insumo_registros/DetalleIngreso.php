<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    protected $table = 'insumo.detalle_ingreso';

    protected $fillable = [
        'deting_id',
        'deting_ins_id',
        'deting_prov_id',
        'deting_cantidad',
        'deting_costo',
        'deting_fecha_venc',
        'deting_ing_id',
        'deting_registrado',
        'deting-modificado',
        'deting_estado'
    ];
    protected $primaryKey = 'deting_id';

    public $timestamps = false;
}
