<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table = 'acopio.municipio';

    protected $fillable = [
        'mun_id',
        'mun_nombre',
        'mun_id_dep'
    ];
    protected $primaryKey = 'mun_id';
    public $timestamps = false;

    protected static function combo()
    {
        $data = Municipio::select('mun_id', 'mun_nombre')
            //->where('estcivil_estado', 'A')
            ->get();
            return $data;
    }
}
