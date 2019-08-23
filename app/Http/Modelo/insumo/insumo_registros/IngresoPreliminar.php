<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class IngresoPreliminar extends Model
{
    protected $table = 'insumo.ingreso_preliminar';

    protected $fillable = [
        'ingpre_id',
        'ingpre_id_tiping',
        'ingpre_nrofactura',
        'ingpre_factura',
        'ingpre_remision',
        'ingpre_fecha_remision',
        'ingpre_nrocontrato',
        'ingpre_enumeracion',
        'ingpre_usr_id',
        'ingpre_planta_id',
        'ingpre_registrado',
        'ingpre_modificado',
        'ingpre_estado',
    ];
    protected $primaryKey = 'ingpre_id';

    public $timestamps = false;
}
