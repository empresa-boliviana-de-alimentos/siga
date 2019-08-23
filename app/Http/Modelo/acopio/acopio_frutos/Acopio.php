<?php

namespace siga\Modelo\acopio\acopio_frutos;

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
        'aco_tipo',

        'aco_estadofru',
        'aco_variedad',
        'aco_lac_grma',
        'aco_fru_rel',
        'aco_fru_dm',
        'aco_fru_long',
        'aco_fru_brix',
        'aco_fru_lote',
        'aco_fru_mues',
        'aco_resp_calidad',

        'aco_cant_rep',
        'aco_fru_calibre',
        'aco_fru_tam',
        'aco_fru_categoria',
        'aco_fru_corona',
        'aco_fru_peso',
        'aco_fru_zumo',
        'aco_id_planta',
        'aco_fru_sincorona',
    ];
    protected $primaryKey = 'aco_id';

    public $timestamps = false;

   /* public function Usuario()
    {
        return HasMany('gamlp\Persona');
    }*/
  /*  protected static function getListar()
    {
        $regacopio = Acopio::select( 'aco_id', 'aco_id_comp','aco_id_recep', 'aco_fecha_acop', 'aco_cantidad', 'aco_cert')
                 ->where('aco_estado','A')->where('aco_id_linea','2')
                 ->orderBy('aco_id_recep','ASC')
                 ->get();  
        return $regacopio;
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
