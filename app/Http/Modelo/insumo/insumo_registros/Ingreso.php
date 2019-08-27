<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $table = 'insumo.ingreso';

    protected $fillable = [
        'ing_id',
        'ing_id_tiping',
        'ing_nrofactura',
        'ing_factura',
        'ing_remision',
        'ing_fecha_remision',
        'ing_nrocontrato',
        'ing_enumeracion',
        'ing_usr_id',
        'ing_planta_id',
        'ing_registrado',
        'ing_modificado',
        'ing_estado',
        'ing_env_acop_id',
        'ing_obs',
        'ing_planta_traspaso',
    ];
    protected $primaryKey = 'ing_id';

    public $timestamps = false;
}
