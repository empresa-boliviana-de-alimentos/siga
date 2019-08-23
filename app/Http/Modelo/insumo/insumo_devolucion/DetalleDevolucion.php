<?php

namespace siga\Modelo\insumo\insumo_devolucion;

use Illuminate\Database\Eloquent\Model;

class DetalleDevolucion extends Model
{
    protected $table = 'insumo.detalle_devolucion';

    protected $fillable = [
        'detdevo_id',
        'detdevo_devo_id',
        'detdevo_ins_id',
        'detdevo_cantidad',
        'detdevo_registrado',
        'detdevo_modificado',
        'detdevo_estado'
    ];

    protected $primaryKey = 'detdevo_id';

    public $timestamps = false;
}
