<?php

namespace siga\Modelo\acopio\acopio_miel;

use Illuminate\Database\Eloquent\Model;

class Tipo_Proveedor extends Model
{
    protected $table      = 'acopio.tipo_proveedor';

    protected $fillable   = [
        'tprov_id',
        'tprov_tipo',
        'tprov_estado',
        'tprov_id_linea'        
    ];

    public $timestamps = false;

    protected $primaryKey = 'tprov_id';

    protected static function getListar()
    {
        $tipo_proveedor = Tipo_Proveedor::all();
           
        return $tipo_proveedor;
    }
    //  protected static function getDestroy($id)
    // {
    //     $acopio = Acopio::where('id_acopio', $id)->update(['estado' => '0']);
    //     return $acopio;
    // }
}
