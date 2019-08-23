<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class TipoIngreso extends Model
{
    protected $table = 'insumo.tipo_ingreso';

    protected $fillable = [
        'ting_id',
        'ting_nombre',
        'ting_usr_id',
        'ting_registrado',
        'ting_modificado',
        'ting_estado',
    ];
    protected $primaryKey = 'ting_id';

    public $timestamps = false;

    protected static function setBuscar($id) {
        $ingreso = TipoIngreso::where('ting_id', $id)->first();
        return $ingreso;
    }

    protected static function getDestroy($id) {
        $ingreso = TipoIngreso::where('ting_id', $id)->update(['ting_estado' => 'B']);
        return $ingreso;
    }
}
