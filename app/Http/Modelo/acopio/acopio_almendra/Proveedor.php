<?php

namespace siga\Modelo\acopio\acopio_almendra;

use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Proveedor extends Model {
	protected $table = 'acopio.proveedor';

	protected $fillable = [
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
		'prov_id_usr'
	];
	protected $primaryKey = 'prov_id';

	public $timestamps = false;

	public function Usuario() {
		return HasMany('siga\Proveedor');
	}
	protected static function getListar() {
		$user      = Auth::user()->usr_id;
		$proveedor = Proveedor::join('acopio.departamento as dep', 'acopio.proveedor.prov_exp', '=', 'dep.dep_id')
			->where('prov_estado', 'A')
			->where('prov_id_usr', $user)
			->where('prov_id_linea', 1)
			->get();
		return $proveedor;
	}
	protected static function setBuscar($id) {
		$proveedor = Proveedor::where('prov_id', $id)->first();
		return $proveedor;
	}
	protected static function setBuscarNumaco($id) {
		$proveedor = Proveedor::join('acopio.acopio as aco', 'acopio.proveedor.prov_id', '=', 'aco.aco_id_prov')->select('proveedor.prov_id', 'proveedor.prov_nombre', 'proveedor.prov_ap', 'proveedor.prov_am', 'proveedor.prov_ci', DB::raw('MAX(aco_numaco) as nroaco'))
		                                                                                                        ->where('acopio.proveedor.prov_id', $id)->groupBy('proveedor.prov_id', 'proveedor.prov_nombre', 'proveedor.prov_ap', 'proveedor.prov_am', 'proveedor.prov_ci')->first();
		return $proveedor;
	}
	protected static function getDestroy($id) {
		$proveedor = Proveedor::where('prov_id', $id)->update(['prov_estado' => 'B']);
		return $proveedor;
	}
	protected static function setBuscarAco($id) {

		$proveedor = Proveedor::join('acopio.acopio as aco', 'acopio.proveedor.prov_id', '=', 'aco.aco_id_prov')->select(DB::raw('MAX(aco_numaco) as nroaco'))

		->where('acopio.proveedor.prov_id', $id)->first();

		return $proveedor;
	}

	protected static function combo() {
		$data = Proveedor::select('prov_id', 'prov_nombre', 'prov_ap', 'prov_am')
			->where('prov_estado', 'A')
			->get();
		return $data;
	}

	protected static function getListarApp($id) {
		//$user      = Auth::user()->usr_id;
		$proveedor = Proveedor::select('prov_id', 'prov_nombre', 'prov_ap', 'prov_am', 'prov_ci', 'prov_exp', 'prov_tel', 'prov_id_usr', 'prov_id_tipo', 'prov_id_convenio', 'prov_departamento', 'prov_id_provincia', 'prov_id_municipio', 'prov_id_comunidad', 'prov_id_asociacion', 'prov_id_linea')
			->where('prov_estado', 'A')
			->where('prov_id_usr', $id)
			->where('prov_id_linea', 1)
			->get();
		return $proveedor;
	}
}
