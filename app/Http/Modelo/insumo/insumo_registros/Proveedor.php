<?php

namespace siga\Modelo\insumo\insumo_registros;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;

use Auth;

class Proveedor extends Model
{
     protected $table = 'insumo.proveedor';

    protected $fillable = [
        'prov_id',
        'prov_nom',
        'prov_dir',
        'prov_tel',
        'prov_nom_res',
        'prov_ap_res',
        'prov_am_res',
        'prov_tel_res',
        'prov_obs',
        'prov_usr_id',
        'prov_registrado',
        'prov_modificado',
        'prov_estado',
        'prov_id_planta'
    ];
    protected $primaryKey = 'prov_id';

    public $timestamps = false;

    public function Usuario()
    {
        return HasMany('gamlp\Proveedor');
    }
    protected static function getListar()
    {
        //$planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();
        //$id=$planta->id_planta;
        $user=Auth::user()->usr_id;
        $proveedor = Proveedor::where('prov_estado', 'A')
                    //->where('prov_usr_id', $user)
                    //->where('prov_id_planta',$id)
                    ->where('prov_id','<>',1)
                    ->get();
        return $proveedor;
    }

     protected static function setBuscar($id)
    {
        $proveedor = Proveedor::where('prov_id', $id)->first();
        return $proveedor;
    }
    protected static function getDestroy($id)
    {
        $proveedor = Proveedor::where('prov_id', $id)->update(['prov_estado' => 'B']);
        return $proveedor;
    }

     protected static function combo()
    {
        $proveedor = Proveedor::select('prov_id', 'prov_nom')
                            ->get();
        return $proveedor;
    }
}
