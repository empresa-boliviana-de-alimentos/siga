<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;

class Sabor extends Model
{
    protected $table = 'insumo.sabor';

    protected $fillable = [
        'sab_id',
        'sab_nombre',
        'sab_usr_id',
        'sab_registrado',
        'sab_modificado',
        'sab_estado',
    ];
    protected $primaryKey = 'sab_id';

    public $timestamps = false;

    protected static function setBuscar($id) {
        $sabor = Sabor::where('sab_id', $id)->first();
        return $sabor;
    }

    protected static function getDestroy($id) {
        $sabor = Sabor::where('sab_id', $id)->update(['sab_estado' => 'B']);
        return $sabor;
    }
}
