<?php

namespace siga\Modelo\acopio\acopio_lacteos;
use Auth;

use Illuminate\Database\Eloquent\Model;

//class Persona extends Model
class Acopio extends Model
{
    protected $table = 'acopio.acopio';

    protected $fillable = [

        'aco_id',
        'aco_id_prov',
        'aco_id_recep',
        'aco_obs',
        'aco_id_tipo_cas',
        'aco_cantidad',
        'aco_centro',
        'aco_num_rec',
        'aco_cos_un',
        'aco_cos_total',
        'aco_numaco',
        'aco_unidad',
        'aco_peso_neto',
        'aco_fecha_acop',
        'aco_id_proc',
        'aco_id_comunidad',
        //'aco_tipo_env',
        'aco_con_hig',
        'aco_tram',
        'aco_pago',
        'aco_num_act',
        'aco_fecha_rec',
        'aco_id_destino',
        'aco_id_prom',
        'aco_id_linea',
        'aco_id_usr',
        'aco_fecha_reg',
        'aco_estado', 
        'aco_lac_tem', 
        'aco_lac_aci', 
        'aco_lac_ph', 
        'aco_lac_sng', 
        'aco_lac_den', 
        'aco_lac_mgra', 
        'aco_lac_palc', 
        'aco_lac_pant', 
        'aco_lac_asp', 
        'aco_lac_col', 
        'aco_lac_olo', 
        'aco_lac_sab', 
        'aco_id_comp',
        'aco_cert', 

        'aco_cant_rep',
        'aco_detlac_id',
        'aco_id_planta',
        'aco_estado_env',
        'aco_id_modulo'
    ];
    protected $primaryKey = 'aco_id';

    public $timestamps = false;

   /* public function Usuario()
    {
        return HasMany('gamlp\Persona');
    }*/
    protected static function getListar()
    {
        $regacopio = Acopio::select( 'aco_id', 'aco_id_comp','aco_id_recep', 'aco_fecha_acop', 'aco_cantidad', 'aco_cert')
                 ->where('aco_estado','A')->where('aco_id_linea','2')
                 ->orderBy('aco_id_recep','ASC')
                 ->get();  
        return $regacopio;
    }
    
     protected static function setBuscar($id)
    {
        $usr = Auth::user()->usr_id;

        $acopio = \DB::table('acopio.acopio')
               ->join('public._bp_usuarios', 'acopio.acopio.aco_id_usr', '=', 'usr_id')
               ->join('public._bp_personas', '_bp_usuarios.usr_prs_id', '=', 'public._bp_personas.prs_id')
               ->where('aco_detlac_id',$id)
               ->where('aco_id_usr',$usr)
               ->first();
        return $acopio;
    }
 
    // protected static function getDestroy($id)
    // {
    //     $proveedor = Proveedor::where('id_proveedor', $id)
    //     ->update(['estado' => '2']);
    //     return $proveedor;
    // }
}
