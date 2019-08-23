<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'insumo.municipio';

    protected $fillable = [
        'muni_id',
        'muni_nombre',
        'muni_usr_id',
        'muni_registrado',
        'muni_modificado',
        'muni_estado',
    ];
    protected $primaryKey = 'muni_id';

    public $timestamps = false;

    protected static function setBuscar($id) {
        $municipio = Municipio::where('muni_id', $id)->first();
        return $municipio;
    }

    protected static function getDestroy($id) {
        $municipio = Municipio::where('muni_id', $id)->update(['muni_estado' => 'B']);
        return $municipio;
    }
}
