<?php

namespace siga\Http\Modelo\acopio\acopio_lacteos;

use Illuminate\Database\Eloquent\Model;

class Conductor extends Model {
	protected $table = 'producto_terminado.conductor';
	protected $fillable = ['pcd_id', 'pcd_id_estado_civil', 'pcd_ci', 'pcd_nro_licencia', 'pcd_categoria', 'pcd_nombres', 'pcd_paterno', 'pcd_materno', 'pcd_direccion', 'pcd_telefono', 'pcd_celular', 'pcd_correo', 'pcd_sexo', 'pcd_fec_nacimiento', 'pcd_registrado', 'pcd_modificado', 'pcd_usr_id', 'pcd_estado', 'pcd_veh_id'];
	public $timestamps = false;
	protected $primaryKey = 'pcd_id';

	protected static function getListarConductor() {
		$conductor = Conductor::select()
			->join('producto_terminado.vehiculos as vv', 'vv.veh_id', '=', 'pcd_veh_id')
			->where('pcd_estado', 'A')
			->orderBy('pcd_id', 'DESC')
			->get();
		return $conductor;
	}
	protected static function getId() {
		$id = Conductor::select('pcd_id')
			->orderBy('pcd_id', 'DESC')
			->first();
		return $id;
	}

	protected static function getDestroy($id) {
		$conductor = Conductor::where('pcd_id', $id)->update(['pcd_estado' => 'B']);
		return $conductor;
	}

	protected static function getConductor($id) {
		$conductor = Conductor::where('pcd_id', $id)
			->where('pcd_estado', 'A')
			->first();
		return $conductor;
	}
}
