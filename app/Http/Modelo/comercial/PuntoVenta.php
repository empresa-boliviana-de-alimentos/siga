<?php

namespace siga\Http\Modelo\comercial;

use Illuminate\Database\Eloquent\Model;

class PuntoVenta extends Model
{
    protected $table = 'comercial.punto_venta_comercial';

    protected $fillable = [
        'pv_id',
        'pv_tipopv_id',
        'pv_codigo',
        'pv_nombre',
        'pv_descripcion',
        'pv_direccion',
        'pv_telefono',
        'pv_usr_responsable',
        'pv_depto_id',
        'pv_actividad_economica',
        'pv_fecha_inicio',
        'pv_fecha_fin',
        'pv_usr_id',
        'pv_registrado',
        'pv_modificado',
        'pv_estado'
    ];

    protected $primaryKey = 'pv_id';

    public $timestamps = false;
}
