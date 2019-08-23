<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class DetalleIngresoPreliminar extends Model
{
    protected $table = 'insumo.detalle_ingreso_preliminar';

    protected $fillable = [
        'detingpre_id',
        'detingpre_ins_id',
        'detingpre_prov_id',
        'detingpre_cantidad',
        'detingpre_costo',
        'detingpre_fecha_venc',
        'detingpre_ingpre_id',
        'detingpre_registrado',
        'detingpre-modificado',
        'detingpre_estado'
    ];
    protected $primaryKey = 'detingpre_id';

    public $timestamps = false;
}
