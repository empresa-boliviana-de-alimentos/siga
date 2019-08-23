<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class LineaProduccion extends Model
{
    protected $table = 'insumo.linea_produccion';

    protected $fillable = [
        'linea_prod_id',
        'linea_prod_nombre',
        'linea_prod_usr_id',
        'linea_prod_registrado',
        'linea_prod_modificado',
        'linea_prod_estado',
    ];
    protected $primaryKey = 'linea_prod_id';

    public $timestamps = false;

    protected static function setBuscar($id) {
        $linea = LineaProduccion::where('linea_prod_id', $id)->first();
        return $linea;
    }

    protected static function getDestroy($id) {
        $linea = LineaProduccion::where('linea_prod_id', $id)->update(['linea_prod_estado' => 'B']);
        return $linea;
    }
}
