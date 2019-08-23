<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class Partida extends Model
{
    protected $table = 'insumo.partida';

    protected $fillable = [
        'part_id',
        'part_codigo',
        'part_nombre',
        'part_usr_id',
        'part_registrado',
        'part_modificado',
        'part_estado',
    ];
    protected $primaryKey = 'part_id';

    public $timestamps = false;

    protected static function combo()
    {
        $combo = Partida::select('part_id', 'part_nombre')
                        ->where('part_estado','A')
                        ->get();
        return $combo;
    }   

    protected static function setBuscar($id) {
        $partida = Partida::where('part_id', $id)->first();
        return $partida;
    }

    protected static function getDestroy($id) {
        $partida = Partida::where('part_id', $id)->update(['part_estado' => 'B']);
        return $partida;
    }
}
