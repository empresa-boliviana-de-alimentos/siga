<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class SubLinea extends Model
{
    protected $table = 'insumo.sub_linea';

    protected $fillable = [
        'sublin_id',
        'sublin_nombre',
        'sublin_prod_id',
        'sublin_usr_id',
        'sublin_registrado',
        'sublin_modificado',
        'sublin_estado',
    ];
    protected $primaryKey = 'sublin_id';

    public $timestamps = false;

    protected static function setBuscar($id) {
        $sub = SubLinea::where('sublin_id', $id)->first();
        return $sub;
    }

    protected static function getDestroy($id) {
        $sub = SubLinea::where('sublin_id', $id)->update(['sublin_estado' => 'B']);
        return $sub;
    }
}
