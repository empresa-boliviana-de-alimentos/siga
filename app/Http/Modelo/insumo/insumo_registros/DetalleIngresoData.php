<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class DetalleIngresoData extends Model
{
    protected $table = 'insumo.detalle_data_carringreso';

    protected $fillable = [
        'detcar_id',
        'detcar_id_carr',
        'detcar_id_ins',
        'detcar_id_prov',
        'detcar_id_planta',
        'detcar_cantidad',
        'detcar_costo_uni',
        'detcar_costo_tot',
        'detcar_usr_id',
        'detcar_registrado',
        'detcar_cant_actual',
    ];
    protected $primaryKey = 'detcar_id';

    public $timestamps = false;
}
