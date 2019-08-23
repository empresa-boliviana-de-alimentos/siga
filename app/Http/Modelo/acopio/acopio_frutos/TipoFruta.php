<?php

namespace siga\Modelo\acopio\acopio_frutos;

use Illuminate\Database\Eloquent\Model;

class TipoFruta extends Model
{
    protected $table      = 'acopio.tipo_fruta';

    protected $fillable   = [
        'tipfr_id',
        'tipfr_nombre',
        'tipfr_estado',
        'tipfr_fecha_reg'      
    ];

    public $timestamps = false;

    protected $primaryKey = 'tipfr_id';

    protected static function getListar()
    {
         
    }

     protected static function combo()
    {
        $data = TipoFruta::select('tipfr_id', 'tipfr_nombre')
            ->where('tipfr_estado', 'A')
            ->get();
        return $data;
    }
}
