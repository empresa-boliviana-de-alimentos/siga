<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class TipoCastania extends Model
{
    protected $table = 'acopio.tipo_castania';

    protected $fillable = [
        'tca_id',
        'tca_nombre',
        'tca_estado',
        'tca_fecha_reg'
    ];
    protected $primaryKey = 'tca_id';
    public $timestamps = false;

    protected static function comboTipo()
    {
        $data = TipoCastania::select('tca_id', 'tca_nombre')
         		->get();
        return $data;
    }
}
