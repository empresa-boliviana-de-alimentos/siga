<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class Mercado extends Model
{
    protected $table = 'insumo.mercado';

    protected $fillable = [
        'mer_id',
        'mer_nombre',
        'mer_usr_id',
        'mer_registrado',
        'mer_modificado',
        'mer_estado',
    ];
    protected $primaryKey = 'mer_id';

    public $timestamps = false;

    protected static function setBuscar($id) {
        $mercado = Mercado::where('mer_id', $id)->first();
        return $mercado;
    }

    protected static function getDestroy($id) {
        $mercado = Mercado::where('mer_id', $id)->update(['mer_estado' => 'B']);
        return $mercado;
    }
}
