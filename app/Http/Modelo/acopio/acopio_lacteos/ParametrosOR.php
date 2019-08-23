<?php

namespace gamlp\Modelo\acopio\acopio_lacteos;

use Illuminate\Database\Eloquent\Model;

//class Persona extends Model
class ParametrosOR extends Model
{
    
    protected $table      = 'acopio.prop_org';
    protected $fillable   =  [
        'id_prop_org',
        'descripcion',
        'id_linea_trabajo',
        'estado',
        'por_aspecto',
        'por_olor',
        'por_color',
        'por_sabor',
    ];
    public $timestamps    = false;
    protected $primaryKey = 'id_prop_org';
   /* protected static function combo()
    {
       
    }*/
    protected static function ultimoid_por()
    {
        $ultimo_id_por = $_POST['id_prop_org'];
        return $ultimo_id_por;
    }
}
