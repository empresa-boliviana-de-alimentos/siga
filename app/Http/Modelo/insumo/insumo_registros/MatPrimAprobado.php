<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class MatPrimAprobado extends Model
{
    protected $table = 'insumo.matprima_aprobado';

    protected $fillable = [
        'prim_id',
        'prim_id_enval',
        'prim_cant_enval',
        'prim_unidad',
        'prim_tipo_ins',
        'prim_cant',
        'prim_costo',
        'prim_codnum',
        'prim_gestion',
        'prim_id_planta',
        'prim_estado',
        'prim_usr_id',
        'prim_registrado',
        'prim_obs'
    ];
    protected $primaryKey = 'prim_id';

    public $timestamps = false;

}
