<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class Tipo_Proveedor extends Model
{
    protected $table = 'acopio.tipo_proveedor';

    protected $fillable = [
        'tprov_id',
        'tprov_tipo',
        'tprov_estado',
        'tprov_id_linea'
    ];
    protected $primaryKey = 'tprov_id';
    public $timestamps = false;

    protected static function combo()
    {
        $data = Tipo_Proveedor::select('tprov_id', 'tprov_tipo')->where('tprov_id_linea','=','1')
            ->get();
        return $data;
    }
}
