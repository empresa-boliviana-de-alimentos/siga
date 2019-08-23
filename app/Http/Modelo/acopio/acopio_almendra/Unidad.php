<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class Unidad extends Model
{
    protected $table = 'acopio.unidad';

    protected $fillable = [
        'uni_id',
        'uni_nombre',
        'uni_sigla',
        'uni_estado'
    ];
    protected $primaryKey = 'uni_id';
    public $timestamps = false;

    protected static function comboUnidad()
    {
        $data = Unidad::select('uni_id', 'uni_nombre')
         		->get();
        return $data;
    }
}
