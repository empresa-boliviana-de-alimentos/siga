<?php

namespace siga\Modelo\acopio\acopio_lacteos;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;
use siga\Modelo\admin\ProveedorL;
//class Persona extends Model
class AcopioCA extends Model
{
    protected $table = 'acopio.det_acop_ca';

    protected $fillable = [
        'dac_id',
        'dac_id_prov',
        'dac_cert',
        'dac_fecha_acop',
        'dac_hora',
        'dac_cant_uni',
        'dac_obs',
        'dac_cond',
        'dac_tem',
        'dac_sng',
        'dac_palc',
        'dac_aspecto',
        'dac_color',
        'dac_olor',
        'dac_sabor',
        'dac_tenv',
        'dac_estado',
        'dac_fecha_reg',
        'dac_id_rec',
        'dac_id_linea',
        'dac_id_planta'
    ];
    protected $primaryKey = 'dac_id';

    public $timestamps = false;

   /* public function Usuario()
    {
        return HasMany('gamlp\Persona');
    }*/
    protected static function getListarAc($id)
    {
        $listacop = AcopioCA::select( 'dac_id', 'dac_id_prov', 'dac_fecha_acop', 'dac_hora', 'dac_cant_uni', 'dac_tem', 'dac_sng','dac_palc','dac_aspecto','dac_color','dac_olor','dac_sabor')
                 ->where('dac_estado',1)  ->where('dac_id_prov',$id)
                 ->orderBy('dac_id','ASC')
                 ->get();  
        return $listacop;
    }
      protected static function imprimir_acopioCA($fecha)
    {
        $listacop =  AcopioCA::join('acopio.proveedor as p','acopio.det_acop_ca.dac_id_prov', '=', 'p.prov_id')   
              ->select('dac_id','dac_id_prov','dac_fecha_acop','dac_hora','dac_cant_uni','dac_obs','dac_tem','dac_sng','dac_palc','dac_aspecto','dac_color','dac_olor','dac_sabor','dac_tenv','dac_estado','dac_fecha_reg','dac_id_rec', 'prov_nombre', 'prov_ap', 'prov_am')
              ->where('dac_id_linea','2')
              ->where('dac_estado', '1')
        ->where('dac_fecha_acop',$fecha)
        ->orderBy('dac_id','ASC')
        ->get();
        return $listacop;
    }

   /* public function mostrarusr()
    {
    $ids=Auth::user()->usr_id;
    //$usuario = Usuario::setBuscarLac($ids);
      //  return response()->json($usuario);
    $usuario = Usuario::select('prov_id', 'usr_usuario')
            ->where('prov_id', $ids)
            ->get();
            return $usuario;
    }*/
    /*
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
    }*/

}
