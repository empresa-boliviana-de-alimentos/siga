<?php

namespace siga\Modelo\acopio\acopio_frutos;

use Illuminate\Database\Eloquent\Model;

class Comunidad extends Model
{
   protected $table      = 'acopio.comunidad';

    protected $fillable   = [
        'com_id',
        'com_nombre',
        'com_id_mun',
        'com_estado',
        'com_id_prov',
        'com_id_linea'        
    ];

    public $timestamps = false;

    protected $primaryKey = 'com_id';

    protected static function getListar()
    {
        $comunidad = Comunidad::all();
           
        return $comunidad;
    }
}
