<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;

class LugarCompra extends Model
{
    protected $table = 'acopio.lugar_proc';

    protected $fillable = [
        'proc_id',
        'proc_nombre',
        'proc_estado',
        'proc_fecha_reg'
    ];
    protected $primaryKey = 'proc_id';
    public $timestamps = false;

    protected static function comboLugar()
    {
        $data = LugarCompra::select('proc_id', 'proc_nombre')->where('proc_id_linea','=',1)
         		->get();
        return $data;
    }
}
