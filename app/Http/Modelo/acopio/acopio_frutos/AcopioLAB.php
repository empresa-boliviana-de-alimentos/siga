<?php

namespace siga\Modelo\acopio\acopio_frutos;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;

//class Persona extends Model
class AcopioLAB extends Model
{
    protected $table = 'acopio.det_acoreslac';

    protected $fillable = [
        'detlac_id',
        'detlac_id_rec',
        'detlac_fecha',
        'detlac_cant',
        'detlac_obs',
        'detlac_tem',
        'detlac_sng',
        'detlac_palc',
        'detlac_aspecto',
        'detlac_color',
        'detlac_olor',
        'detlac_sabor',
        'detlac_estado',
        'detlac_fecha_reg',
        'detlac_cant_prov',
        'detlac_est_reg',
        'detlac_nom_rec',
        'detlac_envio',
        'detlac_id_linea',
        'detlac_tot_descortefru',
        'detlac_prov_nombre'
    ];
    protected $primaryKey = 'detlac_id';

    public $timestamps = false;

   /* public function Usuario()
    {
        return HasMany('gamlp\Persona');
    }*/
    protected static function getListar()
    {
        $listacop = AcopioLAB::select( 'detlac_id', 'detlac_id_rec', 'detlac_fecha', 'detlac_cant', 'detlac_obs', 'detlac_tem', 'detlac_sng','detlac_palc','detlac_aspecto','detlac_color','detlac_sabor','detlac_estado','detlac_fecha_reg','detlac_cant_prov','detlac_est_reg','detlac_nom_rec','detlac_envio','detlac_tot_descortefru','detlac_prov_nombre')
                 ->  where('detlac_envio','S') 
                 ->where('detlac_id_linea',4)
                 ->orderBy('detlac_id','DESC')
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
   
     protected static function setBuscar($id)
    {
        $proveedor=AcopioLAB::where('detlac_id',$id)
        ->where('detlac_estado','A')
        ->first();
        return $proveedor;
    }
 protected static function setBuscar22($id,$fec)
    {
        $proveedor=AcopioLAB::where('detlac_id_rec',$id)
        ->where('detlac_estado','A')
        ->where('detlac_fecha',$fec)
        ->first();
        return $proveedor;
    }

  /*
    protected static function getDestroy($id)
    {
        $proveedor = Proveedor::where('id_proveedor', $id)
        ->update(['estado' => '2']);
        return $proveedor;
    }*/
}
