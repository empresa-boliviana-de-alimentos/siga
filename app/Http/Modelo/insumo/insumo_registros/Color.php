<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table = 'insumo.color';

    protected $fillable = [
        'col_id',
        'col_nombre',
        'col_usr_id',
        'col_registrado',
        'col_modificado',
        'col_estado',
    ];
    protected $primaryKey = 'col_id';

    public $timestamps = false;

    protected static function setBuscar($id) {
        $color = Color::where('col_id', $id)->first();
        return $color;
    }

    protected static function getDestroy($id) {
        $color = Color::where('col_id', $id)->update(['col_estado' => 'B']);
        return $color;
    }
}
