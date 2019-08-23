<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class TipoEnvase extends Model
{
    protected $table = 'insumo.tipo_envase';

    protected $fillable = [
        'tenv_id',
        'tenv_nombre',
        'tenv_usr_id',
        'tenv_registrado',
        'tenv_modificado',
        'tenv_estado',
    ];
    protected $primaryKey = 'tenv_id';

    public $timestamps = false;

    protected static function setBuscar($id) {
        $tipoenvase = TipoEnvase::where('tenv_id', $id)->first();
        return $tipoenvase;
    }

    protected static function getDestroy($id) {
        $tipoenvase = TipoEnvase::where('tenv_id', $id)->update(['tenv_estado' => 'B']);
        return $tipoenvase;
    }
}
