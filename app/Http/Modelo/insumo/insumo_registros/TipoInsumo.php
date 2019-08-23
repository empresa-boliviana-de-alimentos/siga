<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class TipoInsumo extends Model
{
    protected $table = 'insumo.tipo_insumo';

    protected $fillable = [
        'tins_id',
        'tins_nombre',
        'tins_usr_id',
        'tins_registrado',
        'tins_modificado',
        'tins_estado',
    ];
    protected $primaryKey = 'tins_id';

    public $timestamps = false;

    protected static function setBuscar($id) {
        $tipinsumo = TipoInsumo::where('tins_id', $id)->first();
        return $tipinsumo;
    }

    protected static function getDestroy($id) {
        $tipinsumo = TipoInsumo::where('tins_id', $id)->update(['tins_estado' => 'B']);
        return $tipinsumo;
    }
}
