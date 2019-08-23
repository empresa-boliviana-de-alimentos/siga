<?php

namespace siga\Modelo\insumo\insumo_devolucion;

use Illuminate\Database\Eloquent\Model;

class Devolucion_Recibidas extends Model
{
    protected $table = 'insumo.devolucion_recibidas';

    protected $fillable = [
        'devrec_id',
        'devrec_id_dev',
        'devrec_num_salida',
        'devrec_nom_receta',
        'devrec_tipo_sol',
        'devrec_data',
        'devrec_cod_num',
        'devrec_gestion',
        'devrec_id_planta',
        'devrec_usr_id',
        'devrec_registrado',
        'devrec_estado',
    ];

    protected $primaryKey = 'devrec_id';

    public $timestamps = false;
}
