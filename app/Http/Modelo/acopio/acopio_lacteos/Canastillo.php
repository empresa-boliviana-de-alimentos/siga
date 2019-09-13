<?php

namespace siga\Http\Modelo\acopio\acopio_lacteos;

use Illuminate\Database\Eloquent\Model;

class Canastillo extends Model {
	protected $table = 'producto_terminado.canastillos';
	protected $fillable = ['ctl_id', 'ctl_descripcion', 'ctl_codigo', 'ctl_rece_id', 'ctl_altura', 'ctl_altura', 'ctl_ancho', 'ctl_largo', 'ctl_peso', 'ctl_material', 'ctl_observacion', 'ctl_logo', 'ctl_almacenamiento', 'ctl_transporte', 'ctl_aplicacion', 'ctl_foto_canastillo', 'ctl_registrado', 'ctl_modificado', 'ctl_usr_id', 'ctl_estado'];
	public $timestamps = false;
	protected $primaryKey = 'ctl_id';

	protected static function getListarCanastillos() {
		$vehiculos = Canastillo::select()
			->where('ctl_estado', 'A')
			->orderBy('ctl_id', 'DESC')
			->get();
		return $vehiculos;
	}
	protected static function getId() {
		$id = Canastillo::select('ctl_id')
			->orderBy('ctl_id', 'DESC')
			->first();
		return $id;
	}

	protected static function getDestroy($id) {
		$vehiculos = Canastillo::where('ctl_id', $id)->update(['ctl_estado' => 'B']);
		return $vehiculos;
	}

	protected static function getCanastillos($id) {
		$vehiculos = Canastillo::where('ctl_id', $id)
			->where('ctl_estado', 'A')
			->first();
		return $vehiculos;
	}

}
