<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    protected $table = 'insumo.unidad_medida';

    protected $fillable = [
        'umed_id',
        'umed_nombre',
        'umed_sigla',
        'umed_usr_id',
        'umed_registrado',
        'umed_modificado',
        'umed_estado',
    ];
    protected $primaryKey = 'umed_id';

    public $timestamps = false;

    protected static function setBuscar($id) {
        $medida = UnidadMedida::where('umed_id', $id)->first();
        return $medida;
    }

    protected static function getDestroy($id) {
        $medida = UnidadMedida::where('umed_id', $id)->update(['umed_estado' => 'B']);
        return $medida;
    }
}
