<?php

namespace siga\Modelo\acopio\acopio_frutos;

use Illuminate\Database\Eloquent\Model;
use siga\Modelo\admin\Usuario;
use siga\Modelo\admin\ProveedorM;
class AcopioRF extends Model
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
        'dac_id_tipofru',
        'dac_tot_descartefru',
        'dac_calibrefru',
        'dac_ramhojafru',
        'dac_infestfru',
        'dac_dañadosfru',
        'dac_extrañosfru',
        'dac_lotefru',
        'dac_preciofru',
        'dac_nomchofer',
        'dac_placa',
        'dac_cantaprob',
        'dac_id_planta',
        'dac_id_acopio',
        'dac_pesotot',
        'dac_cantot',
        'dac_ci_chofer',
        'dac_tipo_vehi',
        'dac_peso_fru',
        'dac_descant_fru',
        'dac_despeso_fru',
    ];
    protected $primaryKey = 'dac_id';

    public $timestamps = false;

   
    protected static function getListarAc($id)
    {
        $listacop = AcopioRF::select( 'dac_id', 'dac_id_prov', 'dac_fecha_acop', 'dac_hora', 'dac_cant_uni', 'dac_tem', 'dac_sng','dac_palc','dac_aspecto','dac_color','dac_olor','dac_sabor')
                 ->where('dac_estado','A')  ->where('dac_id_prov',$id)
                 ->orderBy('dac_id','ASC')
                 ->get();  
        return $listacop;
    }

     protected static function setBuscar($id)
    {
        $proveedor=AcopioRF::join('acopio.proveedor as prov','acopio.det_acop_ca.dac_id_prov', '=', 'prov.prov_id')
        ->join('acopio.tipo_fruta as tip', 'acopio.det_acop_ca.dac_id_tipofru', '=', 'tip.tipfr_id')
        ->where('dac_id', $id)
        ->first();
      
        return $proveedor;
    }

     protected static function setBuscar1($id)
    {
        $proveedor=AcopioRF:://join('acopio.acopio as aco','acopio.det_acop_ca.dac_id_acopio', '=', 'aco.aco_id')
                            join('acopio.proveedor as prov','acopio.det_acop_ca.dac_id_prov', '=', 'prov.prov_id')
                            ->leftjoin('acopio.departamento as dep','prov.prov_departamento', '=', 'dep.dep_id')
                            ->leftjoin('acopio.provincia as provi','prov.prov_id_provincia', '=', 'provi.provi_id')
                            ->leftjoin('acopio.comunidad as com','prov.prov_id_comunidad', '=', 'com.com_id')
                            ->leftjoin('acopio.tipo_fruta as tip', 'acopio.det_acop_ca.dac_id_tipofru', '=', 'tip.tipfr_id')
                            ->where('dac_id', $id)
                            ->first();
      
        return $proveedor;
    }

    protected static function setBuscarmod($id)
    {
        $proveedor=AcopioRF:://join('acopio.acopio as aco','acopio.det_acop_ca.dac_id_acopio', '=', 'aco.aco_id')
                            join('acopio.proveedor as prov','acopio.det_acop_ca.dac_id_prov', '=', 'prov.prov_id')
                            ->leftjoin('acopio.tipo_fruta as tip', 'acopio.det_acop_ca.dac_id_tipofru', '=', 'tip.tipfr_id')
                            ->where('dac_id_acopio', $id)
                            ->first();
      
        return $proveedor;
    }

}
