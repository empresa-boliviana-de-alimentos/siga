<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class ProductoEspecifico extends Model
{
    protected $table = 'insumo.producto_especifico';

    protected $fillable = [
        'prod_esp_id',
        'prod_esp_nombre',
        'prod_esp_usr_id',
        'prod_esp_registrado',
        'prod_esp_modificado',
        'prod_esp_estado',
    ];
    protected $primaryKey = 'prod_esp_id';

    public $timestamps = false;

    protected static function setBuscar($id) {
        $prod = ProductoEspecifico::where('prod_esp_id', $id)->first();
        return $prod;
    }

    protected static function getDestroy($id) {
        $prod = ProductoEspecifico::where('prod_esp_id', $id)->update(['prod_esp_estado' => 'B']);
        return $prod;
    }
}
