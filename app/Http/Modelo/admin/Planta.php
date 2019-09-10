<?php

namespace siga\Http\Modelo\admin;

use Illuminate\Database\Eloquent\Model;

class Planta extends Model
{
    protected $table = 'public._bp_planta';

    protected $fillable = [
        'id_planta',
        'nombre_planta',
        'id_linea_produccion',
        'tipo'
    ];

    protected $primaryKey = 'id_planta';

    public $timestamps = false;
}
