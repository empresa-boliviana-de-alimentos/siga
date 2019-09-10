<?php

namespace siga\Http\Modelo\comercial;

use Illuminate\Database\Eloquent\Model;

class DetalleSolicitudPv extends Model
{
    protected $table = 'comercial.detalle_solcitud_pv_comercial';

    protected $fillable = [
        'detsolpv_id',
        'detsolpv_solpv_id',
        'detsolpv_prod_id',
        'detsolpv_cantidad',
        'detsolpv_registrado',
        'detsolpv_modificado',
        'detsolpv_estado'
    ];

    protected $primaryKey = 'detsolpv_id';

    public $timestamps = false;
}
