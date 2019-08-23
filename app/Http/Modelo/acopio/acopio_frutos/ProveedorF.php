<?php

namespace siga\Modelo\acopio\acopio_frutos;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;
use Auth;

class ProveedorF extends Model
{
    protected $table      = 'acopio.proveedor';

    protected $fillable   = [
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
        'prov_id_usr',
        'prov_id_provincia',   
        'prov_id_planta'
    ];

    public $timestamps = false;

    protected $primaryKey = 'prov_id';

    protected static function getListar()
    {
        $user = Auth::user()->usr_id;
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')
                            ->select('planta.id_planta')
                            ->where('usr_id','=',$user)
                            ->first(); 
        $proveedor = ProveedorF::where('prov_estado', 'A')
                              ->where('prov_id_linea',4)
                              ->where('prov_id_usr',$user)
                              ->where('prov_id_planta',$planta['id_planta'])
                              ->OrderBy('prov_id', 'desc')
                              ->get();
        return $proveedor;
    }

    protected static function setBuscar($id)
    {
        $proveedor = ProveedorF::join('acopio.departamento as dep','acopio.proveedor.prov_departamento', '=', 'dep.dep_id')
                                ->join('acopio.comunidad as com','acopio.proveedor.prov_id_comunidad', '=', 'com.com_id')
                                ->leftjoin('acopio.provincia as provi','acopio.proveedor.prov_id_provincia', '=', 'provi.provi_id')
                                ->where('prov_id', $id)->first();
        return $proveedor;
    }

    protected static function getDestroy($id)
    {
        $proveedor = ProveedorF::where('prov_id', $id)->update(['prov_estado' => 'B']);
        return $proveedor;
    }
    protected static function combo()
    {
        $data = ProveedorF::select('prov_id', 'prov_nombre','prov_ap','prov_am')
            ->where('prov_estado', 'A')
            ->get();
            return $data;
    }
    protected static function combo2($id)
    {
        $data = ProveedorF::select('prov_id', 'prov_nombre','prov_ap','prov_am')
            ->where('prov_estado', 'A')->where('prov_id', $id)
            ->get();
            return $data;
    }
}
