<?php

namespace siga\Modelo\acopio\acopio_miel;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;
use Auth;

class Acopio extends Model
{
    protected $table      = 'acopio.acopio';

    protected $fillable   = [
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
        'aco_tipo',
        'aco_mat_prim',
        'aco_latitud',
        'aco_longitud',
	    'aco_nro_boleta',
        'aco_tipo_matp',
        'aco_id_planta'
    ];

    public $timestamps = false;

    protected $primaryKey = 'aco_id';

    protected static function getListar()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 
        // $acopio = Acopio::where('aco_estado', 'A')
        //     ->get();
        $acopio = Acopio::join('acopio.proveedor as p','acopio.acopio.aco_id_prov', '=', 'p.prov_id')
                         ->join('acopio.propiedades_miel as prom', 'acopio.acopio.aco_id_prom','=','prom.prom_id')
                         ->select('acopio.acopio.aco_id','p.prov_id','p.prov_nombre', 'p.prov_ap','p.prov_am', 'acopio.acopio.aco_num_act', 'acopio.acopio.aco_fecha_acop','prom.prom_total','prom.prom_peso_bruto','prom.prom_peso_neto','acopio.acopio.aco_mat_prim','acopio.acopio.aco_numaco')
                        ->where('acopio.acopio.aco_id_linea','=',3 )
                        ->where('acopio.acopio.aco_estado', '=','A')
                        ->where('acopio.acopio.aco_tipo', '=' , 3)
                        ->where('acopio.acopio.aco_estado_env','=',0)
                        // ->where('acopio.acopio.aco_id_usr','=',Auth::user()->usr_id)
                        ->where('acopio.acopio.aco_id_planta','=',$planta->id_planta)
                        ->OrderBy('acopio.acopio.aco_id', 'DESC')
                ->get();
        // dd($acopio);
        return $acopio;
    }
    protected static function getListarProd()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first(); 
        $acopio = Acopio::join('acopio.proveedor as p','acopio.acopio.aco_id_prov', '=', 'p.prov_id')
                         ->join('acopio.propiedades_miel as prom', 'acopio.acopio.aco_id_prom','=','prom.prom_id')
                         ->select('acopio.acopio.aco_id','p.prov_id','p.prov_nombre', 'p.prov_ap','p.prov_am', 'acopio.acopio.aco_num_act', 'acopio.acopio.aco_fecha_acop','prom.prom_total_marcos','prom.prom_cantidad_baldes','prom.prom_peso_neto','prom.prom_centrifugado','prom.prom_peso_bruto_filt','prom_peso_bruto_centrif','prom.prom_peso_bruto_imp','prom.prom_colmenas','acopio.acopio.aco_mat_prim','acopio.acopio.aco_numaco')
                        ->where('acopio.acopio.aco_id_linea','=',3 )
                        ->where('acopio.acopio.aco_estado', '=','A')
                        ->where('acopio.acopio.aco_tipo', '=' , 2)
                        ->where('acopio.acopio.aco_estado_env','=',0)
                        // ->where('acopio.acopio.aco_id_usr','=',Auth::user()->usr_id)
                        ->where('acopio.acopio.aco_id_planta','=',$planta->id_planta)
                        ->OrderBy('acopio.acopio.aco_id', 'DESC')
                ->get();
        return $acopio;
    }

    protected static function getListarConvenio()
    {
        $planta = Usuario::join('public._bp_planta as planta','public._bp_usuarios.usr_planta_id','=','planta.id_planta')->select('planta.id_planta')->where('usr_id','=',Auth::user()->usr_id)->first();  
        $acopio = Acopio::join('acopio.proveedor as p','acopio.acopio.aco_id_prov', '=', 'p.prov_id')
                         ->join('acopio.propiedades_miel as prom', 'acopio.acopio.aco_id_prom','=','prom.prom_id')
                         ->join('acopio.pagos as pago','acopio.acopio.aco_id','=','pago.pago_id_aco')
                         ->join('acopio.contrato as cont','pago.pago_id_contrato','=','cont.contrato_id')
                         ->select('acopio.acopio.aco_id','p.prov_id','p.prov_nombre', 'p.prov_ap','p.prov_am', 'acopio.acopio.aco_num_act', 'acopio.acopio.aco_fecha_acop','prom.prom_total_marcos','prom.prom_cantidad_baldes','prom.prom_peso_bruto','prom.prom_peso_neto','prom.prom_centrifugado','prom.prom_peso_bruto_filt','prom_peso_bruto_centrif','prom.prom_peso_bruto_imp','prom.prom_colmenas','acopio.acopio.aco_mat_prim','prom.prom_total','cont.contrato_nro','acopio.acopio.aco_numaco','acopio.acopio.aco_fecha_reg')
                        ->where('acopio.acopio.aco_id_linea','=',3 )
                        ->where('acopio.acopio.aco_estado', '=','A')
                        ->where('acopio.acopio.aco_tipo', '=' , 1)
                        ->where('acopio.acopio.aco_estado_env','=',0)
                        ->where('acopio.acopio.aco_id_planta','=',$planta->id_planta)
                        ->OrderBy('acopio.acopio.aco_id', 'DESC')
                ->get();
        //dd($acopio);
        return $acopio;
    }
     protected static function getDestroy($id)
    {
        $acopio = Acopio::where('aco_id', $id)->update(['aco_estado' => 'B']);
        return $acopio;
    }

}
