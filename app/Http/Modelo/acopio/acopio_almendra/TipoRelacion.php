<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class TipoRelacion extends Model
{
    protected $table = 'acopio.tipo_relacion';

    protected $fillable = [
        'tiprel_id',
        'tiprel_nombre',
        'tiprel_id_garantia',
        'tiprel_estado',
    ];
    protected $primaryKey = 'tiprel_id';
    public $timestamps = false;

    protected static function combo()
    {
        $data = TipoRelacion::select('tiprel_id', 'tiprel_nombre')
            ->where('tiprel_estado', 'A')
            ->where('tiprel_id_garantia', 1)
            ->get();
            return $data;
    }

    protected static function combo1()
    {
        $data = TipoRelacion::select('tiprel_id', 'tiprel_nombre')
            ->where('tiprel_estado', 'A')
            ->where('tiprel_id_garantia', 2)
            ->get();
            return $data;
    }
}
