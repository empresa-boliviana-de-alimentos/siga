<?php

namespace siga\Modelo\acopio\acopio_lacteos;

use Illuminate\Database\Eloquent\Model;

class Precio extends Model
{
     protected $table     = 'acopio.precio';
    protected $fillable   =  [
        'precio_id',
        'precio_gestion',
        'precio_id_planta',
        'precio_ini_fecha',
        'precio_costo',
        'precio_contrato',
        'precio_fin_fecha',
        'precio_registrado',
        'precio_modificado',
        'precio_usr_id',
        'precio_estado',
        'precio_id_linea'
    ];
    public $timestamps    = false;
    protected $primaryKey = 'precio_id';
}
