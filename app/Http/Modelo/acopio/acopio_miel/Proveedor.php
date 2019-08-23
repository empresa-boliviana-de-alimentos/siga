<?php

namespace siga\Modelo\acopio\acopio_miel;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;
use Auth;

class Proveedor extends Model
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
        'prov_id_planta',
        'prov_fecha_insrau',
        'prov_fecha_venrau',
        'prov_doc_pdf'
    ];

    public $timestamps = false;

    protected $primaryKey = 'prov_id';

    protected static function getListar()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        $proveedor = Proveedor::where('prov_estado', 'A')->where('prov_id_linea',3)->OrderBy('prov_id', 'desc')
                    // ->where('prov_id_usr','=',Auth::user()->usr_id)
                    ->where('prov_id_planta','=',$planta->id_planta)
                    ->get();
        return $proveedor;
    }

    protected static function getDestroy($id)
    {
        $proveedor = Proveedor::where('prov_id', $id)->update(['prov_estado' => 'B']);
        return $proveedor;
    }
}
