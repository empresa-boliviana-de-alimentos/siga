<?php

namespace siga\Modelo\acopio\acopio_lacteos;

use Illuminate\Database\Eloquent\Model;

//class Persona extends Model
class ProveedorL extends Model
{
    protected $table = 'acopio.proveedor';

    protected $fillable = [
        'prov_id',
        'prov_nombre',
        'prov_ap',
        'prov_am',
        'prov_ci',
        'prov_exp',
        'prov_tel',
        'prov_foto',
        'prov_id_tipo',
        'prov_id_convenio',
        'prov_departamento',
        'prov_id_municipio',
        'prov_id_comunidad',
        'prov_id_asociacion',
        'prov_direccion',
        'prov_rau',
        'prov_nit',
        'prov_cuenta',
        'prov_lugar',
        'prov_id_linea',
        'prov_estado',
        'prov_fecha_reg',
        'prov_id_recep',
        'prov_latitud',
        'prov_longitud',
        'prov_id_modulo',
        'prov_id_usr'
    ];
    protected $primaryKey = 'prov_id';

    public $timestamps = false;

   /* public function Usuario()
    {
        return HasMany('gamlp\Persona');
    }*/
    protected static function getListar($id_modulo)
    {
        $proveedor = ProveedorL::select( 'prov_id', 'prov_nombre', 'prov_ap', 'prov_am', 'prov_ci', 'prov_tel', 'prov_departamento','prov_id_tipo','prov_lugar','prov_rau','prov_nit','prov_cuenta')
                 ->where('prov_estado','A')->where('prov_id_linea','2')
                 ->where('prov_id_modulo','=',$id_modulo)
                 ->orderBy('prov_id','DESC')
                 ->get();  
        return $proveedor;

    }
     protected static function setBuscar($id)
    {
        $proveedor=ProveedorL::where('prov_id',$id)
        ->where('prov_estado','A')
        ->first();
        return $proveedor;
    }
 
    protected static function getDestroy($id)
    {
        $proveedor = ProveedorL::where('prov_id', $id)
        ->update(['prov_estado' => 'B']);
        return $proveedor;
    }

    protected static function combo()
    {
        $data = ProveedorL::select('prov_id', 'prov_nombre','prov_ap','prov_am')
            ->where('prov_estado', 'A')
            ->get();
            return $data;
    }
    protected static function combo2($id)
    {
        $data = ProveedorL::select('prov_id', 'prov_nombre','prov_ap','prov_am')
            ->where('prov_estado', 'A')->where('prov_id', $id)
            ->get();
            return $data;
    }
}
