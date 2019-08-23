<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class TipoGarantia extends Model
{
    protected $table = 'acopio.tipo_garantia';

    protected $fillable = [
        'tipg_garantia_id',
        'tipg_garantia_nombre',
        'tipg_garantia_estado',
    ];
    protected $primaryKey = 'tipg_garantia_id';
    public $timestamps = false;

    protected static function combo()
    {
        $data = TipoGarantia::select('tipg_garantia_id', 'tipg_garantia_nombre')
            ->where('tipg_garantia_estado', 'A')
            ->get();
            return $data;
    }
}
