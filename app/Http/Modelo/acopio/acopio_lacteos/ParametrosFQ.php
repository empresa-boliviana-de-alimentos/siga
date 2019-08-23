<?php

namespace gamlp\Modelo\acopio\acopio_lacteos;

use Illuminate\Database\Eloquent\Model;

//class Persona extends Model
class ParametrosFQ extends Model
{
    
    protected $table      = 'acopio.prop_fq';
    protected $fillable   =  [
        'id_prop_fq',
        'descripcion',
        'id_linea_trabajo',
        'estado',
        'temperatura',
        'densidad',
        'prueba_alcohol',
        'sng',
        'acidez',
        'ph',
        'materia_grasa',
        'prueba_anti',
    ];
    public $timestamps    = false;
    protected $primaryKey = 'id_prop_fq';
   /* protected static function combo()
    {
       
    }*/
    protected static function ultimoid_pfq()
    {
        $ultimo_id_por = $_POST['id_prop_fq'];
        return $ultimo_id_por;
    }
}
