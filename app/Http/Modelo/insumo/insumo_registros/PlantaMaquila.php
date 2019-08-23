<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class PlantaMaquila extends Model
{
    protected $table = 'insumo.planta_maquila';

    protected $fillable = [
        'maquila_id',
        'maquila_nombre',
        'maquila_usr_id',
        'maquila_registrado',
        'maquila_modificado',
        'maquila_estado',
    ];
    protected $primaryKey = 'maquila_id';

    public $timestamps = false;

    protected static function setBuscar($id) {
        $maquila = PlantaMaquila::where('maquila_id', $id)->first();
        return $maquila;
    }

    protected static function getDestroy($id) {
        $maquila = PlantaMaquila::where('maquila_id', $id)->update(['maquila_estado' => 'B']);
        return $maquila;
    }
}
