<?php

namespace siga\Modelo\insumo\insumo_recetas;

use Illuminate\Database\Eloquent\Model;

class DetalleReceta extends Model
{
    protected $table = 'insumo.detalle_receta';

    protected $fillable = [
		'detrece_id',
		'detrece_rece_id',
		'detrece_ins_id',
		'detrece_cantidad',
		'detrece_registrado',
		'detrece_modificado',
		'detrece_estado'
    ];

    protected $primaryKey = 'detrece_id';

    public $timestamps = false;

}
