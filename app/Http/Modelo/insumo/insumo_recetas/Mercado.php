<?php

namespace siga\Modelo\insumo\insumo_recetas;

use Illuminate\Database\Eloquent\Model;

class Mercado extends Model
{
    protected $table = 'insumo.mercado';

    protected $fillable = [
        'merc_id',
        'merc_nombre',
        'merc_usr_id',
        'merc_regsitrado',
        'merc_modificado',
        'merc_estado'
    ];

    protected $primaryKey = 'merc_id';

    public $timestamps = false;

    protected static function getlistar()
    {
        $mercado = Mercado::where('merc_estado', 'A')
            ->get();
        return $mercado;
    }
}
