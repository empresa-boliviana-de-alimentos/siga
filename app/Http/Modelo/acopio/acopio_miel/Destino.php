<?php

namespace siga\Modelo\acopio\acopio_miel;

use Illuminate\Database\Eloquent\Model;

class Destino extends Model
{
    protected $table      = 'acopio.destino';

    protected $fillable   = [
        'des_id',
        'des_descripcion',
        'des_estado',
        'des_fecha_reg'        
    ];

    public $timestamps = false;

    protected $primaryKey = 'des_id';

    protected static function getListar()
    {
        $destino = Destino::all();
           
        return $destino;
    }
}
