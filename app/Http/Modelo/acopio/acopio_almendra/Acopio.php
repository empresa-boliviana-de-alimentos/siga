<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Illuminate\Database\Eloquent\Model;
//use DB;
//use siga\Modelo\acopio\acopio_almendra\Proveedor;

class Acopio extends Model {
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
		'aco_plus'
	];
	protected $primaryKey = 'aco_id';
	public $timestamps    = false;

	public function Usuario() {
		return HasMany('siga\Acopio');
	}

	protected static function getListar1() {
		$proveedor = Acopio::where('aco_estado', 'A')->get();
		return $proveedor;
	}

	protected static function getList($id) {
		$acopio = Acopio::join('acopio.proveedor as p', 'acopio.acopio.aco_id', '=', 'p.prov_id')
			->select('acopio.acopio.aco_id', 'p.prov_id', 'p.prov_nombre', 'p.prov_ci', 'acopio.acopio.aco_numaco', 'acopio.acopio.aco_cantidad', 'acopio.acopio.aco_peso_neto', 'acopio.acopio.aco_cos_total', 'acopio.acopio.aco_id_proc', 'acopio.acopio.aco_fecha_acop', 'acopio.acopio.aco_id_tipo_cas', 'acopio.acopio.aco_num_rec')
			->where('acopio.acopio.aco_id_prov', 1)
			->where('acopio.acopio.aco_estado', 'A')
			->first();

		return $acopio;
	}

	protected static function getBoletaAcopio($id) {
		/* $acopio = Acopio::join('acopio.proveedor as p','acopio.acopio.aco_id_prov', '=', 'p.prov_id')
		->join('acopio.lugar_proc as lug','acopio.acopio.aco_id_proc', '=', 'lug.proc_id')
		->join('acopio.comunidad as com','acopio.acopio.aco_id_comunidad', '=', 'com.com_id')
		->join('public._bp_personas as per','acopio.acopio.aco_id_usr', '=', 'per.prs_id')
		->select('p.prov_id_tipo','p.prov_id_convenio','acopio.acopio.aco_id','acopio.acopio.aco_id_prov','acopio.acopio.aco_numaco', 'acopio.acopio.aco_cantidad','acopio.acopio.aco_peso_neto','acopio.acopio.aco_cos_total','acopio.acopio.aco_id_proc','acopio.acopio.aco_fecha_acop','acopio.acopio.aco_id_tipo_cas', 'acopio.acopio.aco_num_rec','lug.proc_nombre','com.com_nombre','acopio.acopio.aco_cos_un','per.prs_nombres','per.prs_paterno','per.prs_materno','per.prs_ci')
		->where('acopio.acopio.aco_id', $id)
		->where('acopio.aco_estado', 'A')
		->first();
		dd($acopio);
		return $acopio;*/
		$acopio = Acopio::join('acopio.proveedor as p', 'acopio.acopio.aco_id_prov', '=', 'p.prov_id')
			->join('acopio.lugar_proc as lug', 'acopio.acopio.aco_id_proc', '=', 'lug.proc_id')
			->join('acopio.comunidad as com', 'p.prov_id_comunidad', '=', 'com.com_id')
			->join('public._bp_usuarios as per', 'acopio.acopio.aco_id_usr', '=', 'per.usr_id')
		//  ->select('p.prov_id_tipo','p.prov_id_convenio','acopio.acopio.aco_id','acopio.acopio.aco_id_prov','acopio.acopio.aco_numaco', 'acopio.acopio.aco_cantidad','acopio.acopio.aco_peso_neto','acopio.acopio.aco_cos_total','acopio.acopio.aco_id_proc','acopio.acopio.aco_fecha_acop','acopio.acopio.aco_id_tipo_cas', 'acopio.acopio.aco_num_rec','lug.proc_nombre','com.com_id','com.com_nombre','acopio.acopio.aco_cos_un','per.prs_nombres','per.prs_paterno','per.prs_materno','per.prs_ci')
			->select('p.prov_id', 'p.prov_id_tipo', 'p.prov_id_convenio', 'acopio.acopio.aco_id', 'acopio.acopio.aco_id_prov', 'acopio.acopio.aco_numaco', 'acopio.acopio.aco_cantidad', 'acopio.acopio.aco_peso_neto', 'acopio.acopio.aco_cos_total', 'acopio.acopio.aco_id_proc', 'acopio.acopio.aco_fecha_acop', 'acopio.acopio.aco_id_tipo_cas', 'acopio.acopio.aco_num_rec', 'lug.proc_nombre', 'com.com_id', 'com.com_nombre', 'acopio.acopio.aco_cos_un', 'acopio.acopio.aco_id_usr')
			->where('acopio.acopio.aco_id', $id)
			->where('acopio.aco_estado', 'A')
			->first();
		//  dd($acopio);
		return $acopio;
	}

	protected static function setBuscar($id) {
		//dd('ffff',$id);
		$acopio = Acopio::where('aco_id_prov', $id)->first();
		return $acopio;
	}

}
