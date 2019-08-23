<?php

namespace siga\Modelo\acopio\acopio_miel;

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
    //  protected static function getDestroy($id)
    // {
    //     $acopio = Acopio::where('id_acopio', $id)->update(['estado' => '0']);
    //     return $acopio;
    // }
}
