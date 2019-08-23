<?php

namespace gamlp\Modelo\acopio\acopio_lacteos;

use Illuminate\Database\Eloquent\Model;

//class Persona extends Model
class Proveedor extends Model
{
    protected $table = 'acopio.proveedor';

    protected $fillable = [
        'id_proveedor',
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'ci',
        'exp',
        'telefono',
        'direccion',
        'id_departamento',
        'id_municipio',
        'id_comunidad',
        'id_asociacion',
        'estado',
        'fecha_registro',
        'id_rau',
        'id_tipo_prov',
        'id_convenio',
        'id_usuario',
        'lugar_proveedor',
        'id_linea_trabajo',
        'nit',
        'nro_cuenta',
        'img',
    ];
    protected $primaryKey = 'id_proveedor';

    public $timestamps = false;

   /* public function Usuario()
    {
        return HasMany('gamlp\Persona');
    }*/
    protected static function getListar()
    {
        $proveedor = Proveedor::select( 'id_proveedor', 'nombres', 'apellido_paterno', 'apellido_materno', 'ci', 'telefono', 'id_departamento','id_tipo_prov')
                 ->where('estado','1')->where('id_linea_trabajo','1')
                 ->orderBy('nombres','ASC')
                 ->get();  
        return $proveedor;

    }
     protected static function setBuscar($id)
    {
        $proveedor=Proveedor::where('id_proveedor',$id)
        ->where('estado','1')
        ->first();
        return $proveedor;
    }
 
    protected static function getDestroy($id)
    {
        $proveedor = Proveedor::where('id_proveedor', $id)
        ->update(['estado' => '2']);
        return $proveedor;
    }

    protected static function combo()
    {
        $data = Proveedor::select('id_proveedor', 'nombres','apellido_paterno','apellido_materno')
            ->where('estado', '1')
            ->get();
            return $data;
    }
    protected static function combo2($id)
    {
        $data = Proveedor::select('id_proveedor', 'nombres','apellido_paterno','apellido_materno')
            ->where('estado', '1')->where('id_proveedor', $id)
            ->get();
            return $data;
    }
}
