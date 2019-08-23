<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'insumo.categoria';

    protected $fillable = [
        'cat_id',
        'cat_nombre',
    //    'cat_id_partida',
        'cat_usr_id',
        'cat_registrado',
        'cat_modificado',
        'cat_estado',
    ];
    protected $primaryKey = 'cat_id';

    public $timestamps = false;

    protected static function setBuscar($id) {
        $categoria = Categoria::where('cat_id', $id)->first();
        return $categoria;
    }

    protected static function getDestroy($id) {
        $categoria = Categoria::where('cat_id', $id)->update(['cat_estado' => 'B']);
        return $categoria;
    }
}
