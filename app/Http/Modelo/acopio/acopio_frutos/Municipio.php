<?php

namespace siga\Modelo\acopio\acopio_frutos;

use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
    protected $table      = 'acopio.municipio';

    protected $fillable   = [
        'mun_id',
        'mun_nombre',
        'mun_id_dep'        
    ];

    public $timestamps = false;

    protected $primaryKey = 'mun_id';

    protected static function getListar()
    {
        $municipio = Municipio::all();
           
        return $municipio;
    }
}
