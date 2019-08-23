<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class Asociacion extends Model
{
    protected $table = 'acopio.asociacion';

    protected $fillable = [
        'aso_id',
        'aso_nombre',
        'aso_sigla',
        'aso_id_mun',
        'aso_estado',
        'aso_fecha_reg',
        'aso_id_usr',
        'aso_id_linea'
    ];
    protected $primaryKey = 'aso_id';
    public $timestamps = false;

    protected static function combo()
    {
        $data = Asociacion::select('aso_id', 'aso_nombre')->where('aso_id_linea','=',1)
            ->where('aso_estado', 'A')
            ->get();
            return $data;
    }
}
