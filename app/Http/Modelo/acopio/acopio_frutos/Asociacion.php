<?php

namespace siga\Modelo\acopio\acopio_frutos;

use Illuminate\Database\Eloquent\Model;

class Asociacion extends Model
{
    protected $table      = 'acopio.asociacion';

    protected $fillable   = [
        'aso_id',
        'aso_nombre',
        'aso_sigla',
        'aso_id_mun',
        'aso_estado',
        'aso_fecha_reg',
        'aso_id_usr',
        'aso_id_linea'        
    ];

    public $timestamps = false;

    protected $primaryKey = 'aso_id';

    protected static function getListar()
    {
        $asociacion = Asociacion::all();
           
        return $asociacion;
    }
}
