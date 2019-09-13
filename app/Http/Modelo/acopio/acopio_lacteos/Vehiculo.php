<?php

namespace siga\Http\Modelo\acopio\acopio_lacteos;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model {
	protected $table = 'producto_terminado.vehiculos';
	protected $fillable = ['veh_id', 'veh_placa', 'veh_marca', 'veh_modelo', 'veh_tipo', 'veh_chasis', 'veh_roseta_soat', 'veh_roseta_inspeccion', 'veh_restriccion_transito', 'veh_restriccion_municipio', 'veh_usr_id', 'veh_registrado', 'veh_modificado', 'veh_estado'];
	public $timestamps = false;
	protected $primaryKey = 'veh_id';

	protected static function getListarVehiculos() {
		$vehiculos = Vehiculo::select('veh_id', 'veh_placa', 'veh_marca', 'veh_modelo', 'veh_tipo', 'veh_chasis', 'veh_roseta_inspeccion', 'veh_restriccion_transito', 'veh_restriccion_municipio', 'veh_usr_id', 'veh_estado')
			->where('veh_estado', 'A')
			->orderBy('veh_id', 'DESC')
			->get();
		return $vehiculos;
	}
	protected static function getId() {
		$id = Vehiculo::select('veh_id')
			->orderBy('veh_id', 'DESC')
			->first();
		return $id;
	}

	protected static function getDestroy($id) {
		$vehiculos = Vehiculo::where('veh_id', $id)->update(['veh_estado' => 'B']);
		return $vehiculos;
	}

	protected static function getVehiculos($id) {
		$vehiculos = Vehiculo::where('veh_id', $id)
			->where('veh_estado', 'A')
			->first();
		return $vehiculos;
	}

}
